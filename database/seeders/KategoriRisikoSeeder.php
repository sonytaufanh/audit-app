<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriRisikoSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_risikos')->insert([
            ['kode' => 'JC/KR/25010001', 'nama' => 'Risiko Operasional', 'deskripsi' => 'Risiko terkait kegagalan proses internal', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KR/25010002', 'nama' => 'Risiko Keuangan', 'deskripsi' => 'Risiko terkait kerugian finansial', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KR/25010003', 'nama' => 'Risiko Kepatuhan', 'deskripsi' => 'Risiko terkait pelanggaran regulasi', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KR/25010004', 'nama' => 'Risiko Strategis', 'deskripsi' => 'Risiko terkait strategi bisnis', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KR/25010005', 'nama' => 'Risiko Reputasi', 'deskripsi' => 'Risiko terkait citra perusahaan', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
