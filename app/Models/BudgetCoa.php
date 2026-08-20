<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class BudgetCoa extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = [
        'kode_coa', 'nama', 'tipe', 'departemen_id', 'anggaran',
        'realisasi', 'tahun', 'periode', 'keterangan', 'business_unit_id'
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}