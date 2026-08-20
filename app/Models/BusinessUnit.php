<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama', 'lokasi', 'deskripsi', 'is_active'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}