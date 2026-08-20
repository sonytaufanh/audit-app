<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class Departemen extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = ['kode', 'nama', 'deskripsi', 'is_active', 'business_unit_id'];

    public function auditUniverses()
    {
        return $this->hasMany(AuditUniverse::class);
    }

    public function temuanAudits()
    {
        return $this->hasMany(TemuanAudit::class);
    }

    public function riskRegisters()
    {
        return $this->hasMany(RiskRegister::class);
    }

    public function keyRiskIndicators()
    {
        return $this->hasMany(KeyRiskIndicator::class);
    }

    public function budgetCoas()
    {
        return $this->hasMany(BudgetCoa::class);
    }
}