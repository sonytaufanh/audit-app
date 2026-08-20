<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskMonitoringSeeder extends Seeder
{
    public function run()
    {
        DB::table('risk_monitorings')->insert([
            [
                'risk_register_id' => 1, 'tanggal' => '2025-01-31', 'impact_score' => 4, 'probability_score' => 3,
                'risk_score' => 12, 'risk_level' => 'high', 'catatan' => 'Vendor utama masih beroperasi normal',
                'tindakan' => 'Lanjutkan monitoring bulanan', 'reported_by' => 4, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'risk_register_id' => 2, 'tanggal' => '2025-02-28', 'impact_score' => 3, 'probability_score' => 4,
                'risk_score' => 12, 'risk_level' => 'high', 'catatan' => 'Rupiah melemah 3% terhadap USD',
                'tindakan' => 'Tingkatkan porsi hedging', 'reported_by' => 4, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'risk_register_id' => 3, 'tanggal' => '2025-03-31', 'impact_score' => 5, 'probability_score' => 3,
                'risk_score' => 15, 'risk_level' => 'critical', 'catatan' => 'Terdeteksi 2 percobaan phishing',
                'tindakan' => 'Update firewall dan awareness training', 'reported_by' => 5, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'risk_register_id' => 4, 'tanggal' => '2025-04-30', 'impact_score' => 4, 'probability_score' => 2,
                'risk_score' => 8, 'risk_level' => 'medium', 'catatan' => 'Ada 2 regulasi baru yang perlu dipenuhi',
                'tindakan' => 'Sosialisasi regulasi ke departemen terkait', 'reported_by' => 4, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'risk_register_id' => 5, 'tanggal' => '2025-05-31', 'impact_score' => 3, 'probability_score' => 3,
                'risk_score' => 9, 'risk_level' => 'medium', 'catatan' => 'Ada keterlambatan 2 hari di rute Medan',
                'tindakan' => 'Aktifkan rute alternatif via laut', 'reported_by' => 5, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}