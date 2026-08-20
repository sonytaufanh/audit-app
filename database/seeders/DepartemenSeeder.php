<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartemenSeeder extends Seeder
{
    public function run()
    {
        DB::table('departemens')->insert([
            ['kode' => 'JC/DP/25010001', 'nama' => 'Procurement', 'deskripsi' => 'Pengadaan barang dan jasa', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/DP/25010002', 'nama' => 'Finance & Accounting', 'deskripsi' => 'Keuangan dan akuntansi perusahaan', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/DP/25010003', 'nama' => 'Human Capital', 'deskripsi' => 'SDM dan pengembangan karyawan', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/DP/25010004', 'nama' => 'Information Technology', 'deskripsi' => 'Teknologi informasi dan sistem', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'JC/DP/25010005', 'nama' => 'Operational', 'deskripsi' => 'Operasional dan logistik', 'is_active' => true, 'business_unit_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'BD/DP/25010001', 'nama' => 'Procurement', 'deskripsi' => 'Pengadaan barang dan jasa', 'is_active' => true, 'business_unit_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'BD/DP/25010002', 'nama' => 'Operational', 'deskripsi' => 'Operasional dan logistik', 'is_active' => true, 'business_unit_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SB/DP/25010001', 'nama' => 'Finance & Accounting', 'deskripsi' => 'Keuangan dan akuntansi cabang', 'is_active' => true, 'business_unit_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
