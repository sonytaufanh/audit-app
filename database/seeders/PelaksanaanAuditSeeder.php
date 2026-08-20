<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelaksanaanAuditSeeder extends Seeder
{
    public function run()
    {
        DB::table('pelaksanaan_audits')->insert([
            [
                'kode' => 'JC/PA/25010001', 'audit_plan_id' => 1, 'audit_universe_id' => 1, 'auditor_id' => 2,
                'tanggal_mulai' => '2025-01-06', 'tanggal_selesai' => '2025-03-15', 'status' => 'completed',
                'temuan_sementara' => 'Ditemukan beberapa ketidaksesuaian dalam proses pengadaan', 'realisasi_anggaran' => 120000000,
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/PA/25010002', 'audit_plan_id' => 2, 'audit_universe_id' => 2, 'auditor_id' => 3,
                'tanggal_mulai' => '2025-04-01', 'tanggal_selesai' => null, 'status' => 'in_progress',
                'temuan_sementara' => 'Proses rekonsiliasi memerlukan perbaikan', 'realisasi_anggaran' => 80000000,
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/PA/25010003', 'audit_plan_id' => 3, 'audit_universe_id' => 3, 'auditor_id' => 2,
                'tanggal_mulai' => '2025-05-05', 'tanggal_selesai' => null, 'status' => 'in_progress',
                'temuan_sementara' => null, 'realisasi_anggaran' => 45000000,
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/PA/25010004', 'audit_plan_id' => 1, 'audit_universe_id' => 4, 'auditor_id' => 3,
                'tanggal_mulai' => '2025-02-10', 'tanggal_selesai' => '2025-02-28', 'status' => 'completed',
                'temuan_sementara' => 'Proses onboarding sudah sesuai standar', 'realisasi_anggaran' => 30000000,
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/PA/25010005', 'audit_plan_id' => null, 'audit_universe_id' => 5, 'auditor_id' => 2,
                'tanggal_mulai' => '2025-03-01', 'tanggal_selesai' => null, 'status' => 'not_started',
                'temuan_sementara' => null, 'realisasi_anggaran' => 0,
                'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
