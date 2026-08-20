<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $tables = [
            'tindak_lanjuts',
            'temuan_audits',
            'pelaksanaan_audits',
            'audit_universes',
            'audit_plans',
            'risk_monitorings',
            'key_risk_indicators',
            'risk_registers',
            'budget_coas',
            'kategori_risikos',
            'kriteria_penilaians',
            'departemens',
            'users',
            'business_units',
        ];

        DB::statement('SET session_replication_role = replica');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET session_replication_role = DEFAULT');

        $this->call([
            BusinessUnitSeeder::class,
            DepartemenSeeder::class,
            KategoriRisikoSeeder::class,
            KriteriaPenilaianSeeder::class,
            UserSeeder::class,
            AuditPlanSeeder::class,
            AuditUniverseSeeder::class,
            PelaksanaanAuditSeeder::class,
            TemuanAuditSeeder::class,
            TindakLanjutSeeder::class,
            RiskRegisterSeeder::class,
            KeyRiskIndicatorSeeder::class,
            RiskMonitoringSeeder::class,
            BudgetCoaSeeder::class,
        ]);
    }
}
