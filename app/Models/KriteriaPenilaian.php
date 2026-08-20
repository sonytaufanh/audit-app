<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBusinessUnit;

class KriteriaPenilaian extends Model
{
    use HasFactory, HasBusinessUnit;

    protected $fillable = ['kode', 'nama', 'tipe', 'nilai', 'label', 'deskripsi', 'warna', 'is_active', 'business_unit_id'];
}