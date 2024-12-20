<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function showPaymentPage($projectId)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $project = Project::findOrFail($projectId);
        
        // Cek apakah request datang dari form langsung
        if (request()->has('quantity')) {
            $quantity = request()->quantity;
            $totalAmount = $quantity * 10000; // Harga per lembar Rp 10.000
            
            $item = [
                'quantity' => $quantity,
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

        // Lanjutkan dengan proses pembayaran Midtrans
        $orderId = 'INV-' . time();
        
        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'quantity' => $item['quantity'],
            'amount' => $item['total_amount'],
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
                    'price' => $item['total_amount'],
                    'quantity' => 1,
                    'name' => $project->title,
                ]
            ],
            'callbacks' => [
                'finish' => route('investor.payment.success'),
                'error' => route('investor.payment.error'),
                'pending' => route('investor.payment.pending')
            ]
        ];

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
        // Ambil order_id dari query parameter
        $orderId = $request->query('order_id');
        
        // Cari transaksi berdasarkan order_id
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard')->with('error', 'Transaksi tidak ditemukan');
        }
        // Update status transaksi jika belum success
        if ($transaction->status !== 'success') {
            $transaction->update(['status' => 'success']);
            
            // Update dana terkumpul proyek
            $project = Project::find($transaction->project_id);
            if ($project && $project->fundingDetails) {
                $project->fundingDetails->increment('dana_terkumpul', $transaction->amount);
            }
            
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
        $payload = $request->all();
    
        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $fraudStatus = $payload['fraud_status'] ?? null;

        $transaction = Transaction::where('order_id', $orderId)->first();
        
            $signatureKey = hash('sha512', 
            $request->order_id . 
            $request->status_code . 
            $request->gross_amount . 
            config('midtrans.server_key')
        );
        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        if (!$transaction) {
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $transaction->status = 'success';
            $this->updateProjectFunding($transaction);
        } else if ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        }
            $transaction->save();
        
        return response()->json(['status' => 'success']);
        }

    private function updateProjectFunding($transaction)
    {
        $project = Project::find($transaction->project_id);
        if ($project) {
            $project->fundingDetails->increment('dana_terkumpul', $transaction->amount);
            // Hapus item dari keranjang jika pembayaran sukses
            session()->forget("keranjang.{$transaction->project_id}");
        }
    }
}