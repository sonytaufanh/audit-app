<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;

    protected $fillable = [
        'temuan_audit_id', 'deskripsi', 'tanggal_rencana', 'tanggal_selesai',
        'status', 'penanggung_jawab_id', 'bukti', 'catatan_verifikasi',
        'verified_by', 'verified_at'
    ];

    protected $casts = [
        'tanggal_rencana' => 'date',
        'tanggal_selesai' => 'date',
        'verified_at' => 'datetime',
    ];

    public function temuanAudit()
    {
        return $this->belongsTo(TemuanAudit::class);
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}