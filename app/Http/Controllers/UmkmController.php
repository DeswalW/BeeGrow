<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Umkm;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm = Auth::user()->umkm;
        if (!$umkm) {
            return redirect()->route('umkm.profile.create')
                           ->with('error', 'Silakan lengkapi profil UMKM Anda terlebih dahulu');
        }
        $projects = $umkm->projects;
        return view('umkm.dashboard', compact('projects'));
    }

    public function createProfile()
    {
        $categories = Category::all();
        return view('umkm.profile.create', compact('categories'));
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact' => 'required|string',
            'address' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $umkm = Umkm::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'contact' => $request->contact,
            'address' => $request->address,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('umkm.dashboard')
                        ->with('success', 'Profil UMKM berhasil dibuat!');
    }

    public function create()
    {
        $user = Auth::user();
        $umkm = $user->umkm;
        
        Log::info('User ID: ' . $user->id);
        Log::info('UMKM Data: ', ['umkm' => $umkm]);
        
        if (!$umkm) {
            return redirect()->route('umkm.profile.create')
                           ->with('error', 'Silakan lengkapi profil UMKM Anda terlebih dahulu');
        }
        return view('umkm.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_pendanaan' => 'required|numeric|min:1000000',
            'deadline' => 'required|date|after:today',
            'images.*' => 'image|mimes:jpeg,png|max:2048',
            'images' => 'array|max:6',
        ]);

        $umkm = Auth::user()->umkm;
        
        // Buat proyek
        $project = $umkm->projects()->create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => 'Sedang Berlangsung',
        ]);

        // Upload gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('project-images', 'public');
                $project->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        // Buat funding detail
        $project->fundingDetails()->create([
            'target_pendanaan' => $request->target_pendanaan,
            'dana_terkumpul' => 0,
            'admin_fee_collected' => 0,
        ]);

        return redirect()->route('umkm.dashboard')
                        ->with('success', 'Proyek berhasil ditambahkan!');
    }
}
