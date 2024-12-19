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

        $keranjang = session()->get('keranjang', []);
        if (!isset($keranjang[$projectId])) {
            return redirect()->route('investor.keranjang')
                ->with('error', 'Proyek tidak ditemukan di keranjang');
        }
        $item = $keranjang[$projectId];
        $project = Project::findOrFail($projectId);
            // Buat order ID unik
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

    public function success()
    {
        return view('projects.payments.success');
    }

    public function pending()
    {
        return view('projects.payments.pending');
    }

    public function error()
    {
        return view('projects.payments.error');
    }

    public function notification(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $paymentType = $payload['payment_type'];
        
        $transaction = Transaction::where('order_id', $orderId)->first();
    
    if ($transaction) {
        $transaction->status = $transactionStatus;
        $transaction->payment_type = $paymentType;
        $transaction->payment_code = $payload['payment_code'] ?? null;
        $transaction->payment_date = now();
        $transaction->save();
            // Jika pembayaran sukses, update dana terkumpul di project
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $project = Project::find($transaction->project_id);
            $project->fundingDetails->increment('dana_terkumpul', $transaction->amount);
            session()->forget("keranjang.{$transaction->project_id}");
        }
    }
        return response()->json(['status' => 'success']);
    }
}