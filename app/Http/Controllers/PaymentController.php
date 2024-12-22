<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Project;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Investment;

class PaymentController extends Controller
{

    public function showPaymentPage($projectId)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $project = Project::findOrFail($projectId);
        
        // Cek apakah proyek sudah terdanai penuh
        if ($project->isFullyFunded()) {
            return redirect()->back()->with('error', 'Proyek ini sudah terdanai penuh.');
        }

        // Cek apakah request datang dari form langsung
        if (request()->has('quantity')) {
            $quantity = request()->quantity;
            $subtotal = $quantity * 10000; // Harga per lembar Rp 10.000
            $adminFee = $subtotal * 0.015; // Biaya admin 1,5%
            $totalAmount = $subtotal + $adminFee;
            
            $item = [
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'admin_fee' => $adminFee,
                'total_amount' => $totalAmount
            ];
        } else {
            // Cek dari keranjang
            $keranjang = session()->get('keranjang', []);
            if (!isset($keranjang[$projectId])) {
                return redirect()->route('investor.keranjang')
                    ->with('error', 'Proyek tidak ditemukan di keranjang');
            }
            $item = $keranjang[$projectId];
        }

        // Generate order ID
        $orderId = Str::uuid();

        // Buat record transaksi
        $transaction = Transaction::create([
            'order_id' => $orderId,
            'project_id' => $project->id,
            'user_id' => Auth::id(),
            'quantity' => request()->has('quantity') ? request()->quantity : $item['quantity'],
            'amount' => $item['total_amount'],
            'subtotal' => $item['subtotal'],
            'admin_fee' => $item['admin_fee'],
            'status' => 'pending'
        ]);

        // Setup parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $item['total_amount'],
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $project->id,
                    'price' => $item['subtotal'],
                    'quantity' => 1,
                    'name' => $project->title,
                ],
                [
                    'id' => 'admin-fee',
                    'price' => $item['admin_fee'],
                    'quantity' => 1,
                    'name' => 'Biaya Admin (1,5%)',
                ]
            ],
            'callbacks' => [
                'finish' => route('investor.payment.success'),
                'error' => route('investor.payment.error'),
                'pending' => route('investor.payment.pending')
            ]
        ];

        Config::$appendNotifUrl = route('payment.notification');
        Config::$overrideNotifUrl = true;

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('projects.payment', [
                'project' => $project,
                'item' => $item,
                'snapToken' => $snapToken,
                'clientKey' => config('midtrans.client_key')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function  success(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard')->with('error', 'Transaksi tidak ditemukan');
        }

        // Update status transaksi jika belum success
        if ($transaction->status !== 'success') {
            // 1. Update status transaksi
            $transaction->update(['status' => 'success']);
            
            // 2. Update dana terkumpul di funding_details
            $project = Project::find($transaction->project_id);
            if ($project && $project->fundingDetails) {
                $totals = Transaction::where('project_id', $project->id)
                                   ->where('status', 'success')
                                   ->selectRaw('SUM(subtotal) as total_subtotal, SUM(admin_fee) as total_admin_fee')
                                   ->first();
                
                $project->fundingDetails->update([
                    'dana_terkumpul' => $totals->total_subtotal ?? 0,
                    'admin_fee_collected' => $totals->total_admin_fee ?? 0
                ]);
            }
            
            // 3. Catat riwayat investasi
            Investment::create([
                'user_id' => $transaction->user_id,
                'project_id' => $transaction->project_id,
                'amount' => $transaction->subtotal,
                'quantity' => $transaction->quantity,
                'projected_return' => $transaction->subtotal * 0.2, // Asumsi return 20%
                'status' => 'active'
            ]);
            
            // Hapus item dari keranjang
            session()->forget("keranjang.{$transaction->project_id}");
        }

        return view('projects.payments.success', [
            'transaction' => $transaction,
            'project' => $transaction->project
        ]);
    }
 
    public function pending(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard')->with('error', 'Transaksi tidak ditemukan');
        }
        // Update status transaksi
        if ($transaction->status !== 'pending') {
            $transaction->update(['status' => 'pending']);
        }
        return view('projects.payments.pending', [
            'transaction' => $transaction,
            'project' => $transaction->project
        ]);
    }
    public function error(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard')->with('error', 'Transaksi tidak ditemukan');
        }
        // Update status transaksi
        if ($transaction->status !== 'failed') {
            $transaction->update(['status' => 'failed']);
        }
        return view('projects.payments.error', [
            'transaction' => $transaction,
            'project' => $transaction->project
        ]); 
    }

    public function notification(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            Log::info('Midtrans Notification Received:', $request->all());
            
            $notification = new Notification();
            
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            Log::info('Processing Transaction:', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            $transaction = Transaction::where('order_id', $orderId)->first();

            if (!$transaction) {
                Log::error('Transaction Not Found:', ['order_id' => $orderId]);
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $transaction->status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $transaction->status = 'success';
                    $this->updateProjectFunding($transaction);
                }
            } else if ($transactionStatus == 'settlement') {
                $transaction->status = 'success';
                $this->updateProjectFunding($transaction);
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $transaction->status = 'failed';
            } else if ($transactionStatus == 'pending') {
                $transaction->status = 'pending';
            }

            Log::info('Transaction Updated:', [
                'order_id' => $orderId,
                'new_status' => $transaction->status
            ]);
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Notification Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function updateProjectFunding($transaction)
    {
        $project = Project::find($transaction->project_id);
        if ($project && $project->fundingDetails) {
            // Hitung total subtotal dan admin_fee dari semua transaksi sukses untuk project ini
            $totals = Transaction::where('project_id', $project->id)
                               ->where('status', 'success')
                               ->selectRaw('SUM(subtotal) as total_subtotal, SUM(admin_fee) as total_admin_fee')
                               ->first();
            
            // Update dana_terkumpul dengan total subtotal dari semua transaksi
            $project->fundingDetails->update([
                'dana_terkumpul' => $totals->total_subtotal ?? 0,
                'admin_fee_collected' => $totals->total_admin_fee ?? 0
            ]);
        }
        
        // Hapus item dari keranjang
        session()->forget("keranjang.{$transaction->project_id}");
    }

    public function processPayment(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);
        $user = Auth::user();
        
        // Ambil data dari keranjang atau request langsung
        $item = session()->get('keranjang')[$projectId] ?? [
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * 10000,
            'admin_fee' => ($request->quantity * 10000) * 0.015,
        ];

        // Simpan data investasi
        Investment::create([
            'user_id' => $user->id,
            'project_id' => $projectId,
            'amount' => $item['subtotal'],
            'quantity' => $item['quantity'],
            'projected_return' => $item['subtotal'] * 0.2, // Misalnya return 20%
            'status' => 'active'
        ]);

        // Hapus item dari keranjang jika ada
        if (isset(session()->get('keranjang')[$projectId])) {
            $keranjang = session()->get('keranjang');
            unset($keranjang[$projectId]);
            session()->put('keranjang', $keranjang);
        }

        return redirect()->route('investor.portofolio')->with('success', 'Investasi berhasil!');
    }
}