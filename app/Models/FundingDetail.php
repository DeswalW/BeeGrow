<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundingDetail extends Model
{
    protected $fillable = [
        'project_id',
        'target_pendanaan',
        'dana_terkumpul',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
