<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_register_id', 'tanggal', 'impact_score', 'probability_score',
        'risk_score', 'risk_level', 'catatan', 'tindakan', 'reported_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function riskRegister()
    {
        return $this->belongsTo(RiskRegister::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}