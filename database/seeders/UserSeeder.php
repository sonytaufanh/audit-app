<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Wawan Andang', 'email' => 'wawan@audit.com', 'password' => Hash::make('password'),
                'business_unit_id' => 1, 'nip' => '19850101001', 'jabatan' => 'Audit Manager',
                'role' => 'audit_manager', 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Dewi Sartika', 'email' => 'dewi@audit.com', 'password' => Hash::make('password'),
                'business_unit_id' => 1, 'nip' => '19870215002', 'jabatan' => 'Senior Auditor',
                'role' => 'auditor', 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso', 'email' => 'budi@audit.com', 'password' => Hash::make('password'),
                'business_unit_id' => 2, 'nip' => '19900320003', 'jabatan' => 'Auditor',
                'role' => 'auditor', 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Rina Wijaya', 'email' => 'rina@audit.com', 'password' => Hash::make('password'),
                'business_unit_id' => 1, 'nip' => '19881201004', 'jabatan' => 'Risk Manager',
                'role' => 'risk_manager', 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi', 'email' => 'ahmad@audit.com', 'password' => Hash::make('password'),
                'business_unit_id' => 3, 'nip' => '19920715005', 'jabatan' => 'Risk Officer',
                'role' => 'risk_officer', 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Admin Sistem', 'email' => 'admin@audit.com', 'password' => Hash::make('password'),
                'business_unit_id' => 1, 'nip' => '19800101006', 'jabatan' => 'System Administrator',
                'role' => 'admin', 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}