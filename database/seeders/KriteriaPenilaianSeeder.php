<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaPenilaianSeeder extends Seeder
{
    public function run()
    {
        DB::table('kriteria_penilaians')->insert([
            ['kode' => 'JC/KP/25010001', 'nama' => 'Impact Sangat Rendah', 'tipe' => 'impact', 'nilai' => 1, 'label' => 'Sangat Rendah', 'deskripsi' => 'Dampak hampir tidak terasa', 'warna' => '#22c55e', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010002', 'nama' => 'Impact Rendah', 'tipe' => 'impact', 'nilai' => 2, 'label' => 'Rendah', 'deskripsi' => 'Dampak kecil dan dapat ditangani', 'warna' => '#86efac', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010003', 'nama' => 'Impact Sedang', 'tipe' => 'impact', 'nilai' => 3, 'label' => 'Sedang', 'deskripsi' => 'Dampak sedang, perlu perhatian', 'warna' => '#facc15', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010004', 'nama' => 'Impact Tinggi', 'tipe' => 'impact', 'nilai' => 4, 'label' => 'Tinggi', 'deskripsi' => 'Dampak signifikan terhadap operasional', 'warna' => '#f97316', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010005', 'nama' => 'Impact Sangat Tinggi', 'tipe' => 'impact', 'nilai' => 5, 'label' => 'Sangat Tinggi', 'deskripsi' => 'Dampak kritis terhadap kelangsungan bisnis', 'warna' => '#ef4444', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010006', 'nama' => 'Probability Sangat Rendah', 'tipe' => 'probability', 'nilai' => 1, 'label' => 'Sangat Rendah', 'deskripsi' => 'Hampir tidak mungkin terjadi', 'warna' => '#22c55e', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010007', 'nama' => 'Probability Rendah', 'tipe' => 'probability', 'nilai' => 2, 'label' => 'Rendah', 'deskripsi' => 'Kemungkinan kecil terjadi', 'warna' => '#86efac', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010008', 'nama' => 'Probability Sedang', 'tipe' => 'probability', 'nilai' => 3, 'label' => 'Sedang', 'deskripsi' => 'Mungkin terjadi dalam kondisi tertentu', 'warna' => '#facc15', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010009', 'nama' => 'Probability Tinggi', 'tipe' => 'probability', 'nilai' => 4, 'label' => 'Tinggi', 'deskripsi' => 'Sering terjadi', 'warna' => '#f97316', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/KP/25010010', 'nama' => 'Probability Sangat Tinggi', 'tipe' => 'probability', 'nilai' => 5, 'label' => 'Sangat Tinggi', 'deskripsi' => 'Hampir pasti terjadi', 'warna' => '#ef4444', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
