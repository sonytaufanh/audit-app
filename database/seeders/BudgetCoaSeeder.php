<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BudgetCoaSeeder extends Seeder
{
    public function run()
    {
        DB::table('budget_coas')->insert([
            [
                'kode_coa' => 'JC/BC/25010001', 'nama' => 'Pendapatan Jasa', 'tipe' => 'pendapatan',
                'departemen_id' => 2, 'anggaran' => 5000000000, 'realisasi' => 4200000000,
                'tahun' => 2025, 'periode' => 'Q1', 'keterangan' => 'Pendapatan jasa konsultansi',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode_coa' => 'JC/BC/25010002', 'nama' => 'Beban Gaji', 'tipe' => 'beban',
                'departemen_id' => 3, 'anggaran' => 2500000000, 'realisasi' => 1250000000,
                'tahun' => 2025, 'periode' => 'Q1', 'keterangan' => 'Beban gaji dan tunjangan',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode_coa' => 'JC/BC/25010003', 'nama' => 'Aset Perangkat IT', 'tipe' => 'aset',
                'departemen_id' => 4, 'anggaran' => 800000000, 'realisasi' => 750000000,
                'tahun' => 2025, 'periode' => 'Q1', 'keterangan' => 'Pembelian server dan laptop',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode_coa' => 'JC/BC/25010004', 'nama' => 'Utang Usaha', 'tipe' => 'kewajiban',
                'departemen_id' => 2, 'anggaran' => 1500000000, 'realisasi' => 900000000,
                'tahun' => 2025, 'periode' => 'Q1', 'keterangan' => 'Utang kepada vendor',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode_coa' => 'JC/BC/25010005', 'nama' => 'Modal Disetor', 'tipe' => 'ekuitas',
                'departemen_id' => null, 'anggaran' => 10000000000, 'realisasi' => 10000000000,
                'tahun' => 2025, 'periode' => 'Tahunan', 'keterangan' => 'Modal disetor pemegang saham',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
