<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        Investment::create([
            'project_id' => $project->id,
            'user_id' => Auth::user()->id,
            'amount' => $request->amount,
        ]);

        $project->increment('collected_amount', $request->amount);

        return back()->with('success', 'Investment successful!');
    }

}
