<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    public function portofolio()
    {
        // Ambil data investasi yang sedang berjalan untuk user yang login
        $activeInvestments = Investment::with(['project.umkm', 'project.fundingDetails'])
            ->where('user_id', Auth::user()->id)
            ->where('status', 'active')
            ->get();

        // Hitung total investasi dan proyeksi keuntungan
        $totalInvested = $activeInvestments->sum('amount');
        $projectedReturns = $activeInvestments->sum('projected_return');

        return view('investor.portofolio', compact('activeInvestments', 'totalInvested', 'projectedReturns'));
    }
    public function addToKeranjang(Request $request)
    {
        // Validasi input
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Load project dengan relasi umkm
        $project = Project::with('umkm')->findOrFail($request->project_id);
        
        $quantity = $request->quantity;
        $subtotal = $quantity * 10000;
        $adminFee = $subtotal * 0.015;
        $totalAmount = $subtotal + $adminFee;
    
        $keranjang = session()->get('keranjang', []);
    
        // Pastikan data UMKM tersedia dan ambil nama UMKM (bukan nama user)
        $umkmName = $project->umkm ? $project->umkm->name : 'UMKM';
    
        $cartItem = [
            'project_id' => $project->id,
            'project_name' => $project->title,
            'umkm' => $umkmName,  // Sekarang menggunakan nama UMKM
            'quantity' => $quantity,
            'price' => 10000,
            'subtotal' => $subtotal,
            'admin_fee' => $adminFee,
            'total_amount' => $totalAmount,
        ];
    
        if (!isset($keranjang[$project->id])) {
            $keranjang[$project->id] = $cartItem;
        } else {
            // Update quantity dan total, tapi pertahankan data UMKM
            $existingItem = $keranjang[$project->id];
            $existingItem['quantity'] += $quantity;
            $existingItem['subtotal'] = $existingItem['quantity'] * 10000;
            $existingItem['admin_fee'] = $existingItem['subtotal'] * 0.015;
            $existingItem['total_amount'] = $existingItem['subtotal'] + $existingItem['admin_fee'];
            $keranjang[$project->id] = $existingItem;
        }
    
        session()->put('keranjang', $keranjang);
    
        return redirect()->back()->with('success', 'Proyek berhasil ditambahkan ke keranjang!');
    }
    
    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);
        
        // Debug untuk melihat isi keranjang
        // dd($keranjang);
        
        return view('investor.keranjang', compact('keranjang'));
    } 
}
