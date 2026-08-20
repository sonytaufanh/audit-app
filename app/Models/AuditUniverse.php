<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class AuditUniverse extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'departemen_id', 'tipe',
        'risk_level', 'status', 'last_audit_date', 'audit_frequency_months', 'business_unit_id'
    ];

    protected $casts = [
        'last_audit_date' => 'date',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function pelaksanaanAudits()
    {
        return $this->hasMany(PelaksanaanAudit::class);
    }
}