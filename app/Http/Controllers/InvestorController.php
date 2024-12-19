<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class InvestorController extends Controller
{
    public function portofolio()
    {
        return view('investor.portofolio');
    }
    public function addToKeranjang(Request $request)
    {
        // Validasi input
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Ambil data proyek dari database
        $project = Project::findOrFail($request->project_id);
        
        // Hitung total amount berdasarkan quantity
        $quantity = $request->quantity;
        $totalAmount = $quantity * 10000; // Harga per lembar Rp 10.000
    
        // Ambil keranjang dari session
        $keranjang = session()->get('keranjang', []);
    
        // Siapkan data item keranjang
        $cartItem = [
            'project_id' => $project->id,
            'project_name' => $project->title,
            'quantity' => $quantity,
            'total_amount' => $totalAmount,
        ];
    
        // Tambahkan atau update item di keranjang
        if (!isset($keranjang[$project->id])) {
            // Jika item belum ada di keranjang
            $keranjang[$project->id] = $cartItem;
        } else {
            // Jika item sudah ada di keranjang, update quantity dan total_amount
            $keranjang[$project->id]['quantity'] += $quantity;
            $keranjang[$project->id]['total_amount'] = $keranjang[$project->id]['quantity'] * 10000;
        }
    
        // Simpan keranjang ke session
        session()->put('keranjang', $keranjang);
    
        return redirect()->route('project', ['project_id' => $project->id])
            ->with('success', 'Proyek berhasil ditambahkan ke keranjang!');
    }
    
    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);
        
        // Ambil data project untuk setiap item di keranjang
        foreach ($keranjang as $projectId => &$item) {
            $project = Project::find($projectId);
            if ($project) {
                $item['project_name'] = $project->title;
            }
        }
        
        return view('investor.keranjang', compact('keranjang'));
    } 
}
