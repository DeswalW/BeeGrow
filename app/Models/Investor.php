<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = [
        'project_id',
        'jumlah_investor',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
