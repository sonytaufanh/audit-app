<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class RiskRegister extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'departemen_id', 'kategori_risiko_id',
        'impact_score', 'probability_score', 'risk_score', 'risk_level',
        'penyebab', 'dampak', 'mitigasi', 'status', 'risk_owner_id',
        'tanggal_identifikasi', 'tanggal_review', 'business_unit_id'
    ];

    protected $casts = [
        'tanggal_identifikasi' => 'date',
        'tanggal_review' => 'date',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function kategoriRisiko()
    {
        return $this->belongsTo(KategoriRisiko::class);
    }

    public function riskOwner()
    {
        return $this->belongsTo(User::class, 'risk_owner_id');
    }

    public function keyRiskIndicators()
    {
        return $this->hasMany(KeyRiskIndicator::class);
    }

    public function riskMonitorings()
    {
        return $this->hasMany(RiskMonitoring::class);
    }
}