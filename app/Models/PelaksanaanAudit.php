<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class PelaksanaanAudit extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = [
        'kode', 'audit_plan_id', 'audit_universe_id', 'auditor_id',
        'tanggal_mulai', 'tanggal_selesai', 'status',
        'temuan_sementara', 'realisasi_anggaran', 'business_unit_id'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function auditPlan()
    {
        return $this->belongsTo(AuditPlan::class);
    }

    public function auditUniverse()
    {
        return $this->belongsTo(AuditUniverse::class);
    }

    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function temuanAudits()
    {
        return $this->hasMany(TemuanAudit::class);
    }
}