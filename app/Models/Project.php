<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'title',
        'description',
        'deadline',
        'status',
        'photo',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Relasi
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function fundingDetails()
    {
        return $this->hasOne(FundingDetail::class);
    }

    public function shares()
    {
        return $this->hasOne(Share::class);
    }

    public function investors()
    {
        return $this->hasOne(Investor::class);
    }

    // Accessor untuk data keranjang
    public function toCartArray()
    {
        return [
            'project_id' => $this->id,
            'project_name' => $this->title,
            'quantity' => 0,
            'total_amount' => 0
        ];
    }
}