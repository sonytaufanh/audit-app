<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskRegisterSeeder extends Seeder
{
    public function run()
    {
        DB::table('risk_registers')->insert([
            [
                'kode' => 'JC/RR/25010001', 'nama' => 'Kegagalan Vendor Utama', 'deskripsi' => 'Vendor utama gagal memenuhi kontrak',
                'departemen_id' => 1, 'kategori_risiko_id' => 1, 'impact_score' => 4, 'probability_score' => 3,
                'risk_score' => 12, 'risk_level' => 'high', 'penyebab' => 'Ketergantungan pada single vendor',
                'dampak' => 'Terhambatnya proses procurement', 'mitigasi' => 'Diversifikasi vendor dan kontrak multi-year',
                'status' => 'assessed', 'risk_owner_id' => 4, 'tanggal_identifikasi' => '2025-01-10', 'tanggal_review' => '2025-07-10',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/RR/25010002', 'nama' => 'Fluktuasi Nilai Tukar', 'deskripsi' => 'Fluktuasi kurs mempengaruhi biaya operasional',
                'departemen_id' => 2, 'kategori_risiko_id' => 2, 'impact_score' => 3, 'probability_score' => 4,
                'risk_score' => 12, 'risk_level' => 'high', 'penyebab' => 'Ketidakstabilan ekonomi global',
                'dampak' => 'Kenaikan biaya impor', 'mitigasi' => 'Hedging dan kontrak forward',
                'status' => 'treated', 'risk_owner_id' => 4, 'tanggal_identifikasi' => '2025-01-15', 'tanggal_review' => '2025-07-15',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/RR/25010003', 'nama' => 'Serangan Siber', 'deskripsi' => 'Serangan ransomware atau malware pada sistem',
                'departemen_id' => 4, 'kategori_risiko_id' => 1, 'impact_score' => 5, 'probability_score' => 3,
                'risk_score' => 15, 'risk_level' => 'critical', 'penyebab' => 'Kelemahan sistem keamanan',
                'dampak' => 'Kehilangan data dan downtime sistem', 'mitigasi' => 'Security audit rutin dan backup harian',
                'status' => 'assessed', 'risk_owner_id' => 5, 'tanggal_identifikasi' => '2025-02-01', 'tanggal_review' => '2025-08-01',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/RR/25010004', 'nama' => 'Pelanggaran Regulasi', 'deskripsi' => 'Ketidakpatuhan terhadap regulasi pemerintah',
                'departemen_id' => 3, 'kategori_risiko_id' => 3, 'impact_score' => 4, 'probability_score' => 2,
                'risk_score' => 8, 'risk_level' => 'medium', 'penyebab' => 'Perubahan regulasi yang cepat',
                'dampak' => 'Denda dan sanksi administratif', 'mitigasi' => 'Monitoring regulasi berkala',
                'status' => 'identified', 'risk_owner_id' => 4, 'tanggal_identifikasi' => '2025-03-01', 'tanggal_review' => '2025-09-01',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/RR/25010005', 'nama' => 'Gangguan Rantai Pasok', 'deskripsi' => 'Gangguan pada rantai pasok distribusi',
                'departemen_id' => 5, 'kategori_risiko_id' => 1, 'impact_score' => 3, 'probability_score' => 3,
                'risk_score' => 9, 'risk_level' => 'medium', 'penyebab' => 'Bencana alam atau krisis logistik',
                'dampak' => 'Keterlambatan pengiriman', 'mitigasi' => 'Rute alternatif dan buffer stock',
                'status' => 'monitored', 'risk_owner_id' => 5, 'tanggal_identifikasi' => '2025-02-15', 'tanggal_review' => '2025-08-15',
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
