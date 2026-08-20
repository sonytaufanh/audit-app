<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('audit_plans')->insert([
            [
                'kode' => 'JC/AP/25010001', 'nama' => 'Audit Tahunan Procurement 2025', 'deskripsi' => 'Audit menyeluruh proses pengadaan',
                'tahun' => 2025, 'periode' => 'Q1', 'tanggal_mulai' => '2025-01-06', 'tanggal_selesai' => '2025-03-28',
                'anggaran' => 150000000, 'status' => 'disetujui', 'created_by' => 1, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AP/25010002', 'nama' => 'Audit Keuangan Semester 1', 'deskripsi' => 'Audit laporan keuangan semester pertama',
                'tahun' => 2025, 'periode' => 'Semester 1', 'tanggal_mulai' => '2025-04-01', 'tanggal_selesai' => '2025-06-30',
                'anggaran' => 200000000, 'status' => 'disetujui', 'created_by' => 1, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AP/25010003', 'nama' => 'Audit IT & Keamanan Data', 'deskripsi' => 'Audit sistem informasi dan keamanan siber',
                'tahun' => 2025, 'periode' => 'Q2', 'tanggal_mulai' => '2025-05-05', 'tanggal_selesai' => '2025-07-25',
                'anggaran' => 180000000, 'status' => 'disetujui', 'created_by' => 1, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AP/25010004', 'nama' => 'Audit Operasional Cabang', 'deskripsi' => 'Audit operasional seluruh kantor cabang',
                'tahun' => 2025, 'periode' => 'Q3', 'tanggal_mulai' => '2025-07-01', 'tanggal_selesai' => '2025-09-30',
                'anggaran' => 250000000, 'status' => 'draft', 'created_by' => 1, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AP/25010005', 'nama' => 'Audit Kepatuhan Regulasi', 'deskripsi' => 'Audit kepatuhan terhadap regulasi dan kebijakan',
                'tahun' => 2025, 'periode' => 'Tahunan', 'tanggal_mulai' => '2025-10-01', 'tanggal_selesai' => '2025-12-19',
                'anggaran' => 120000000, 'status' => 'draft', 'created_by' => 1, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
