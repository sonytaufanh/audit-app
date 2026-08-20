<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemuanAuditSeeder extends Seeder
{
    public function run()
    {
        DB::table('temuan_audits')->insert([
            [
                'kode' => 'JC/TA/25010001', 'pelaksanaan_audit_id' => 1, 'departemen_id' => 1,
                'judul' => 'Dokumen tender tidak lengkap', 'deskripsi' => 'Beberapa dokumen tender tidak memiliki justifikasi teknis yang memadai',
                'severity' => 'high', 'tipe' => 'ketidaksesuaian', 'rekomendasi' => 'Lengkapi dokumen justifikasi untuk setiap tender di atas 500 juta',
                'tanggal_temuan' => '2025-01-20', 'status' => 'open', 'target_closure' => '2025-04-20', 'actual_closure' => null,
                'root_cause' => 'Kurangnya pengawasan pada proses tender', 'root_cause_category' => 'Process',
                'assigned_to' => 2, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/TA/25010002', 'pelaksanaan_audit_id' => 1, 'departemen_id' => 1,
                'judul' => 'Vendor tidak terverifikasi', 'deskripsi' => '3 vendor aktif belum melalui proses verifikasi ulang',
                'severity' => 'critical', 'tipe' => 'pelanggaran', 'rekomendasi' => 'Lakukan verifikasi ulang seluruh vendor dalam 30 hari',
                'tanggal_temuan' => '2025-02-05', 'status' => 'in_progress', 'target_closure' => '2025-05-05', 'actual_closure' => null,
                'root_cause' => 'Tidak ada jadwal rutin verifikasi vendor', 'root_cause_category' => 'Policy',
                'assigned_to' => 3, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/TA/25010003', 'pelaksanaan_audit_id' => 2, 'departemen_id' => 2,
                'judul' => 'Selisih rekonsiliasi bank', 'deskripsi' => 'Selisih sebesar Rp 25 juta belum direkonsiliasi selama 3 bulan',
                'severity' => 'high', 'tipe' => 'ketidaksesuaian', 'rekomendasi' => 'Lakukan rekonsiliasi bank mingguan',
                'tanggal_temuan' => '2025-04-15', 'status' => 'open', 'target_closure' => '2025-07-15', 'actual_closure' => null,
                'root_cause' => 'Human Error', 'root_cause_category' => 'Human Error',
                'assigned_to' => 2, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/TA/25010004', 'pelaksanaan_audit_id' => 2, 'departemen_id' => 2,
                'judul' => 'Pencatatan aset tetap tidak akurat', 'deskripsi' => '5 aset dengan nilai total Rp 500 juta tidak tercatat',
                'severity' => 'medium', 'tipe' => 'observasi', 'rekomendasi' => 'Lakukan stock opname aset semesteran',
                'tanggal_temuan' => '2025-04-25', 'status' => 'closed', 'target_closure' => '2025-06-25', 'actual_closure' => '2025-06-10',
                'root_cause' => 'Prosedur pencatatan tidak diikuti', 'root_cause_category' => 'Process',
                'assigned_to' => 3, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kode' => 'JC/TA/25010005', 'pelaksanaan_audit_id' => 4, 'departemen_id' => 3,
                'judul' => 'Pelatihan onboarding tidak terstruktur', 'deskripsi' => 'Modul pelatihan tidak standar dan tidak terdokumentasi',
                'severity' => 'medium', 'tipe' => 'peluang_perbaikan', 'rekomendasi' => 'Buat modul pelatihan onboarding standar',
                'tanggal_temuan' => '2025-02-20', 'status' => 'overdue', 'target_closure' => '2025-05-20', 'actual_closure' => null,
                'root_cause' => 'Belum ada SOP onboarding', 'root_cause_category' => 'Policy',
                'assigned_to' => 2, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
