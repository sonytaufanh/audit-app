<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $tables = [
            'audit_universes',
            'temuan_audits',
            'risk_registers',
            'key_risk_indicators',
        ];

        foreach ($tables as $t) {
            $fkName = "{$t}_departemen_id_foreign";
            DB::statement("ALTER TABLE {$t} DROP CONSTRAINT IF EXISTS {$fkName}");
            DB::statement("ALTER TABLE {$t} ALTER COLUMN departemen_id DROP NOT NULL");
            DB::statement("ALTER TABLE {$t} ADD CONSTRAINT {$fkName} FOREIGN KEY (departemen_id) REFERENCES departemens(id) ON DELETE SET NULL");
        }
    }

    public function down()
    {
        $tables = [
            'audit_universes',
            'temuan_audits',
            'risk_registers',
            'key_risk_indicators',
        ];

        foreach ($tables as $t) {
            $fkName = "{$t}_departemen_id_foreign";
            DB::statement("ALTER TABLE {$t} DROP CONSTRAINT IF EXISTS {$fkName}");
            DB::statement("ALTER TABLE {$t} ADD CONSTRAINT {$fkName} FOREIGN KEY (departemen_id) REFERENCES departemens(id) ON DELETE RESTRICT");
        }
    }
};
