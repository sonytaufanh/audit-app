<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class AuditPlan extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'tahun', 'periode',
        'tanggal_mulai', 'tanggal_selesai', 'anggaran', 'status', 'created_by', 'business_unit_id'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pelaksanaanAudits()
    {
        return $this->hasMany(PelaksanaanAudit::class);
    }
}