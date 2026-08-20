<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeyRiskIndicatorSeeder extends Seeder
{
    public function run()
    {
        DB::table('key_risk_indicators')->insert([
            [
                'kode' => 'JC/KRI/25010001', 'nama' => 'Jumlah Vendor Aktif', 'deskripsi' => 'Memantau jumlah vendor yang terdaftar dan aktif',
                'risk_register_id' => 1, 'departemen_id' => 1, 'target' => 50, 'current_value' => 35,
                'threshold_min' => 30, 'threshold_max' => 60, 'satuan' => 'vendor', 'status' => 'yellow',
                'frekuensi' => 'bulanan', 'last_update' => '2025-06-01', 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/KRI/25010002', 'nama' => 'Rasio Hedging Valas', 'deskripsi' => 'Persentase exposure valas yang di-hedging',
                'risk_register_id' => 2, 'departemen_id' => 2, 'target' => 80, 'current_value' => 75,
                'threshold_min' => 60, 'threshold_max' => 90, 'satuan' => '%', 'status' => 'green',
                'frekuensi' => 'mingguan', 'last_update' => '2025-06-15', 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/KRI/25010003', 'nama' => 'Incident Security', 'deskripsi' => 'Jumlah insiden keamanan siber per bulan',
                'risk_register_id' => 3, 'departemen_id' => 4, 'target' => 0, 'current_value' => 2,
                'threshold_min' => 0, 'threshold_max' => 5, 'satuan' => 'insiden', 'status' => 'red',
                'frekuensi' => 'bulanan', 'last_update' => '2025-06-10', 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/KRI/25010004', 'nama' => 'Tingkat Kepatuhan Regulasi', 'deskripsi' => 'Persentase pemenuhan regulasi',
                'risk_register_id' => 4, 'departemen_id' => 3, 'target' => 100, 'current_value' => 92,
                'threshold_min' => 85, 'threshold_max' => 100, 'satuan' => '%', 'status' => 'yellow',
                'frekuensi' => 'triwulan', 'last_update' => '2025-06-01', 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/KRI/25010005', 'nama' => 'On-Time Delivery', 'deskripsi' => 'Persentase pengiriman tepat waktu',
                'risk_register_id' => 5, 'departemen_id' => 5, 'target' => 95, 'current_value' => 88,
                'threshold_min' => 85, 'threshold_max' => 98, 'satuan' => '%', 'status' => 'yellow',
                'frekuensi' => 'mingguan', 'last_update' => '2025-06-14', 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
