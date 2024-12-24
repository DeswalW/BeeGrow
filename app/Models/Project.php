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

    // Tambahkan relasi dengan Investment
    public function investments()
    {
        return $this->hasMany(Investment::class);
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

    public function getRemainingFundingAttribute()
    {
        $target = $this->fundingDetails->target_pendanaan;
        $collected = $this->fundingDetails->dana_terkumpul;
        return max(0, $target - $collected);
    }

    public function getMaxRemainingSharesAttribute()
    {
        return floor($this->remaining_funding / 10000);
    }

    public function isFullyFunded()
    {
        return $this->fundingDetails->dana_terkumpul >= $this->fundingDetails->target_pendanaan;
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

}
