<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessUnitSeeder extends Seeder
{
    public function run()
    {
        DB::table('business_units')->insert([
            ['kode' => 'JC', 'nama' => 'Jakarta Corporate', 'lokasi' => 'Jakarta', 'deskripsi' => 'Kantor pusat perusahaan', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'BD', 'nama' => 'Cabang Bandung', 'lokasi' => 'Bandung', 'deskripsi' => 'Kantor cabang wilayah Jawa Barat', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SB', 'nama' => 'Cabang Surabaya', 'lokasi' => 'Surabaya', 'deskripsi' => 'Kantor cabang wilayah Jawa Timur', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'MD', 'nama' => 'Cabang Medan', 'lokasi' => 'Medan', 'deskripsi' => 'Kantor cabang wilayah Sumatera', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'MK', 'nama' => 'Cabang Makassar', 'lokasi' => 'Makassar', 'deskripsi' => 'Kantor cabang wilayah Indonesia Timur', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
