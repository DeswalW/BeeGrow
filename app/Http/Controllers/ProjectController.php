<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);
        return view('projects.index', compact('project'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'target_amount' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('projects.index');
    }

    public function show($project_id)
    {
        $project = Project::with(['umkm', 'fundingDetails'])->findOrFail($project_id);
        
        if (!$project->umkm) {
            return redirect()->back()->with('error', 'Data UMKM tidak ditemukan');
        }
        
        return view('projects.show', compact('project'));
    }
}
