<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditUniverseSeeder extends Seeder
{
    public function run()
    {
        DB::table('audit_universes')->insert([
            [
                'kode' => 'JC/AU/25010001', 'nama' => 'Proses Pengadaan Barang', 'deskripsi' => 'Seluruh proses procurement dari PR hingga PO',
                'departemen_id' => 1, 'tipe' => 'operasional', 'risk_level' => 'high', 'status' => 'active',
                'last_audit_date' => '2024-06-15', 'audit_frequency_months' => 12, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AU/25010002', 'nama' => 'Laporan Keuangan', 'deskripsi' => 'Proses penyusunan laporan keuangan',
                'departemen_id' => 2, 'tipe' => 'keuangan', 'risk_level' => 'high', 'status' => 'active',
                'last_audit_date' => '2024-12-20', 'audit_frequency_months' => 6, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AU/25010003', 'nama' => 'Sistem ERP', 'deskripsi' => 'Sistem Enterprise Resource Planning perusahaan',
                'departemen_id' => 4, 'tipe' => 'teknologi_informasi', 'risk_level' => 'critical', 'status' => 'active',
                'last_audit_date' => '2024-03-10', 'audit_frequency_months' => 12, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AU/25010004', 'nama' => 'Rekrutmen & Onboarding', 'deskripsi' => 'Proses rekrutmen dan onboarding karyawan',
                'departemen_id' => 3, 'tipe' => 'kepatuhan', 'risk_level' => 'medium', 'status' => 'active',
                'last_audit_date' => null, 'audit_frequency_months' => 12, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/AU/25010005', 'nama' => 'Distribusi & Logistik', 'deskripsi' => 'Proses distribusi dan logistik operasional',
                'departemen_id' => 5, 'tipe' => 'operasional', 'risk_level' => 'medium', 'status' => 'active',
                'last_audit_date' => '2024-09-30', 'audit_frequency_months' => 12, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
