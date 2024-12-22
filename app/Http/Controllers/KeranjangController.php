<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function destroy($projectId)
    {
        $keranjang = session()->get('keranjang', []);
        
        if (isset($keranjang[$projectId])) {
            unset($keranjang[$projectId]);
            session()->put('keranjang', $keranjang);
            return response()->json(['message' => 'Produk berhasil dihapus dari keranjang']);
        }
        
        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }
} 