<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundingDetail extends Model
{
    protected $fillable = [
        'project_id',
        'target_pendanaan',
        'dana_terkumpul',
        'admin_fee_collected',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
