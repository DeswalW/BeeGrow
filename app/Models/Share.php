<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $fillable = [
        'project_id',
        'harga_lembar_saham',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
