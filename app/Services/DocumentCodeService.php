<?php

namespace App\Services;

use App\Models\BusinessUnit;
use Illuminate\Support\Facades\DB;

class DocumentCodeService
{
    protected static $moduleMap = [
        \App\Models\Departemen::class       => 'DP',
        \App\Models\KategoriRisiko::class   => 'KR',
        \App\Models\KriteriaPenilaian::class => 'KP',
        \App\Models\AuditUniverse::class    => 'AU',
        \App\Models\AuditPlan::class        => 'AP',
        \App\Models\PelaksanaanAudit::class => 'PA',
        \App\Models\TemuanAudit::class      => 'TA',
        \App\Models\RiskRegister::class     => 'RR',
        \App\Models\KeyRiskIndicator::class => 'KRI',
        \App\Models\BudgetCoa::class        => 'BC',
    ];

    protected static $kodeColumnMap = [
        \App\Models\BudgetCoa::class => 'kode_coa',
    ];

    public static function generate(string $modelClass): ?string
    {
        $buId = session('active_business_unit_id');
        if (!$buId) {
            return null;
        }

        $bu = BusinessUnit::find($buId);
        if (!$bu) {
            return null;
        }

        $buCode = strtoupper($bu->kode);
        $moduleCode = self::$moduleMap[$modelClass] ?? null;
        if (!$moduleCode) {
            return null;
        }

        $moduleCode = strtoupper($moduleCode);

        $kodeColumn = self::$kodeColumnMap[$modelClass] ?? 'kode';
        $tableName = (new $modelClass)->getTable();
        $now = now();
        $yy = $now->format('y');
        $mm = $now->format('m');
        $prefix = "{$buCode}/{$moduleCode}/{$yy}{$mm}";

        $lastRecord = DB::table($tableName)
            ->where($kodeColumn, 'LIKE', $prefix . '%')
            ->orderByRaw("SUBSTRING({$kodeColumn} FROM LENGTH('{$prefix}') + 1) DESC")
            ->first();

        $seq = 1;
        if ($lastRecord) {
            $lastKode = $lastRecord->{$kodeColumn};
            $seqPart = substr($lastKode, strlen($prefix));
            $seq = (int)$seqPart + 1;
        }

        $seqStr = str_pad((string)$seq, 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$seqStr}";
    }
}
