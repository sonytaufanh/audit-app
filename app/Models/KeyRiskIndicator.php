<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class KeyRiskIndicator extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'risk_register_id', 'departemen_id',
        'target', 'current_value', 'threshold_min', 'threshold_max',
        'satuan', 'status', 'frekuensi', 'last_update', 'business_unit_id'
    ];

    protected $casts = [
        'last_update' => 'date',
    ];

    public function riskRegister()
    {
        return $this->belongsTo(RiskRegister::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}