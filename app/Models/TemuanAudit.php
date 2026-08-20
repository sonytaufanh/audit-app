<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class TemuanAudit extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = [
        'kode', 'pelaksanaan_audit_id', 'departemen_id', 'judul', 'deskripsi',
        'severity', 'tipe', 'rekomendasi', 'tanggal_temuan', 'status',
        'target_closure', 'actual_closure', 'root_cause', 'root_cause_category', 'assigned_to', 'business_unit_id'
    ];

    protected $casts = [
        'tanggal_temuan' => 'date',
        'target_closure' => 'date',
        'actual_closure' => 'date',
    ];

    public function pelaksanaanAudit()
    {
        return $this->belongsTo(PelaksanaanAudit::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function tindakLanjuts()
    {
        return $this->hasMany(TindakLanjut::class);
    }
}