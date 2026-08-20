<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $tables = [
            'departemens',
            'kategori_risikos',
            'kriteria_penilaians',
            'audit_universes',
            'audit_plans',
            'pelaksanaan_audits',
            'temuan_audits',
            'risk_registers',
            'key_risk_indicators',
            'budget_coas',
        ];

        foreach ($tables as $tableName) {
            if (!Schema::hasColumn($tableName, 'business_unit_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('business_unit_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('business_units')
                        ->nullOnDelete();
                });
            }
        }

        DB::statement('ALTER TABLE departemens ALTER COLUMN kode TYPE VARCHAR(20)');
        DB::statement('ALTER TABLE kategori_risikos ALTER COLUMN kode TYPE VARCHAR(20)');
        DB::statement('ALTER TABLE kriteria_penilaians ALTER COLUMN kode TYPE VARCHAR(20)');
    }

    public function down()
    {
        $tables = [
            'departemens',
            'kategori_risikos',
            'kriteria_penilaians',
            'audit_universes',
            'audit_plans',
            'pelaksanaan_audits',
            'temuan_audits',
            'risk_registers',
            'key_risk_indicators',
            'budget_coas',
        ];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'business_unit_id')) {
                Schema::table($table, function (Blueprint $tableBlueprint) use ($table) {
                    $tableBlueprint->dropForeign(['business_unit_id']);
                    $tableBlueprint->dropColumn('business_unit_id');
                });
            }
        }
    }
};
