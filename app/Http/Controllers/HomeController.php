<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Category;
use App\Models\Project;
class HomeController extends Controller
{
    public function welcome()
    {
        $provinces = Province::all();
        $projects = Project::all();
        $categories = Category::all();

        $keranjang = session()->get('keranjang', []);
        $totalKeranjang = count($keranjang);
        return view('dashboard', compact('provinces', 'categories', 'projects'));
    }

    public function index()
    {
        $provinces = Province::all();
        $projects = Project::all();
        $categories = Category::all();

        $keranjang = session()->get('keranjang', []);
        $totalKeranjang = count($keranjang);
        return view('dashboard', compact('provinces', 'categories', 'projects', 'totalKeranjang'));
    }
}