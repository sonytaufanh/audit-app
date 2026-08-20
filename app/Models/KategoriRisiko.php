<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class KategoriRisiko extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = ['kode', 'nama', 'deskripsi', 'is_active', 'business_unit_id'];

    public function riskRegisters()
    {
        return $this->hasMany(RiskRegister::class);
    }
}