<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TindakLanjutSeeder extends Seeder
{
    public function run()
    {
        DB::table('tindak_lanjuts')->insert([
            [
                'temuan_audit_id' => 1, 'deskripsi' => 'Membuat checklist justifikasi teknis tender',
                'tanggal_rencana' => '2025-02-15', 'tanggal_selesai' => '2025-03-10', 'status' => 'completed',
                'penanggung_jawab_id' => 2, 'bukti' => 'Dokumen checklist terlampir',
                'catatan_verifikasi' => 'Checklist sudah diterapkan', 'verified_by' => 1, 'verified_at' => '2025-03-12 10:00:00',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'temuan_audit_id' => 2, 'deskripsi' => 'Verifikasi ulang seluruh vendor terdaftar',
                'tanggal_rencana' => '2025-02-15', 'tanggal_selesai' => null, 'status' => 'in_progress',
                'penanggung_jawab_id' => 3, 'bukti' => null,
                'catatan_verifikasi' => null, 'verified_by' => null, 'verified_at' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'temuan_audit_id' => 3, 'deskripsi' => 'Membuat jadwal rekonsiliasi bank mingguan',
                'tanggal_rencana' => '2025-05-01', 'tanggal_selesai' => null, 'status' => 'open',
                'penanggung_jawab_id' => 2, 'bukti' => null,
                'catatan_verifikasi' => null, 'verified_by' => null, 'verified_at' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'temuan_audit_id' => 4, 'deskripsi' => 'Melakukan stock opname aset tetap',
                'tanggal_rencana' => '2025-05-10', 'tanggal_selesai' => '2025-06-05', 'status' => 'verified',
                'penanggung_jawab_id' => 3, 'bukti' => 'Laporan stock opname terlampir',
                'catatan_verifikasi' => 'Seluruh aset sudah tercatat', 'verified_by' => 1, 'verified_at' => '2025-06-12 14:00:00',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'temuan_audit_id' => 5, 'deskripsi' => 'Menyusun SOP dan modul onboarding',
                'tanggal_rencana' => '2025-03-01', 'tanggal_selesai' => null, 'status' => 'overdue',
                'penanggung_jawab_id' => 2, 'bukti' => null,
                'catatan_verifikasi' => null, 'verified_by' => null, 'verified_at' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}