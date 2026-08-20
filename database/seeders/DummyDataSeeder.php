<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $now = now();

        $truncateOrder = [
            'tindak_lanjuts', 'temuan_audits', 'pelaksanaan_audits',
            'audit_universes', 'audit_plans',
            'risk_monitorings', 'key_risk_indicators', 'risk_registers',
            'budget_coas', 'kriteria_penilaians', 'kategori_risikos',
            'departemens', 'users', 'roles',
        ];
        foreach ($truncateOrder as $t) {
            DB::table($t)->truncate();
        }

        // ============ BUSINESS UNITS (add 7 to existing 3) ============
        $buCount = DB::table('business_units')->count();
        if ($buCount < 10) {
            $newBus = [
                ['kode' => 'SBY', 'nama' => 'Surabaya Branch', 'lokasi' => 'Surabaya', 'deskripsi' => 'East Java regional office', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
                ['kode' => 'MKS', 'nama' => 'Makassar Branch', 'lokasi' => 'Makassar', 'deskripsi' => 'Eastern Indonesia office', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
                ['kode' => 'PLG', 'nama' => 'Palembang Branch', 'lokasi' => 'Palembang', 'deskripsi' => 'Sumatra regional office', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
                ['kode' => 'BPN', 'nama' => 'Balikpapan Branch', 'lokasi' => 'Balikpapan', 'deskripsi' => 'Kalimantan operations', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
                ['kode' => 'DPS', 'nama' => 'Denpasar Branch', 'lokasi' => 'Denpasar', 'deskripsi' => 'Bali regional office', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
                ['kode' => 'PKG', 'nama' => 'Pekanbaru Branch', 'lokasi' => 'Pekanbaru', 'deskripsi' => 'Riau regional office', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
                ['kode' => 'SMG', 'nama' => 'Semarang Branch', 'lokasi' => 'Semarang', 'deskripsi' => 'Central Java office', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ];
            DB::table('business_units')->insert($newBus);
        }
        $buIds = DB::table('business_units')->pluck('id')->toArray();
        $bu1 = $buIds[0];

        // ============ ROLES (10) ============
        $roles = [];
        $roleNames = ['Super Admin', 'Audit Manager', 'Senior Auditor', 'Auditor', 'Risk Manager', 'Risk Officer', 'Compliance Officer', 'Department Head', 'Finance Officer', 'IT Admin'];
        foreach ($roleNames as $i => $name) {
            $roles[] = [
                'kode' => 'R' . str_pad($i + 1, 2, '0', STR_PAD_LEFT), 'nama' => $name, 'deskripsi' => 'Role for ' . $name,
                'can_create' => $i < 5, 'can_read' => true, 'can_update' => $i < 5, 'can_delete' => $i < 3, 'can_approve' => $i < 4,
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('roles')->insert($roles);
        $roleIds = DB::table('roles')->pluck('id')->toArray();

        // ============ DEPARTEMENS (10) ============
        $deptNames = ['Procurement', 'Finance & Accounting', 'Human Capital', 'Information Technology', 'Operations', 'Legal & Compliance', 'Sales & Marketing', 'Supply Chain', 'Internal Audit', 'Health Safety Environment'];
        $deptData = [];
        foreach ($deptNames as $i => $name) {
            $deptData[] = [
                'kode' => 'DP-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name, 'deskripsi' => 'Department of ' . $name,
                'is_active' => true, 'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('departemens')->insert($deptData);
        $deptIds = DB::table('departemens')->pluck('id')->toArray();
        $dept1 = $deptIds[0];

        // ============ KATEGORI RISIKOS (10) ============
        $katNames = ['Operational Risk', 'Financial Risk', 'Compliance Risk', 'Strategic Risk', 'Reputational Risk', 'Cyber Security Risk', 'Fraud Risk', 'Human Resource Risk', 'Supply Chain Risk', 'Environmental Risk'];
        $katData = [];
        foreach ($katNames as $i => $name) {
            $katData[] = [
                'kode' => 'KR-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name, 'deskripsi' => 'Category: ' . $name,
                'is_active' => true, 'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('kategori_risikos')->insert($katData);
        $katIds = DB::table('kategori_risikos')->pluck('id')->toArray();

        // ============ KRITERIA PENILAIANS (10) ============
        $kriteriaData = [];
        $impactLabels = ['Very Low', 'Low', 'Moderate', 'High', 'Very High'];
        $probLabels = ['Rare', 'Unlikely', 'Possible', 'Likely', 'Almost Certain'];
        $colors = ['#22c55e', '#86efac', '#facc15', '#f97316', '#ef4444'];
        for ($i = 0; $i < 5; $i++) {
            $kriteriaData[] = [
                'kode' => 'KP-IM-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'nama' => 'Impact ' . $impactLabels[$i], 'tipe' => 'impact',
                'nilai' => $i + 1, 'label' => $impactLabels[$i],
                'deskripsi' => 'Impact level ' . $impactLabels[$i], 'warna' => $colors[$i],
                'is_active' => true, 'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        for ($i = 0; $i < 5; $i++) {
            $kriteriaData[] = [
                'kode' => 'KP-PR-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'nama' => 'Probability ' . $probLabels[$i], 'tipe' => 'probability',
                'nilai' => $i + 1, 'label' => $probLabels[$i],
                'deskripsi' => 'Probability level ' . $probLabels[$i], 'warna' => $colors[$i],
                'is_active' => true, 'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('kriteria_penilaians')->insert($kriteriaData);

        // ============ USERS (10) ============
        $userNames = ['Andi Wijaya', 'Budi Hartono', 'Citra Lestari', 'Dedi Pratama', 'Eka Saputra', 'Fira Anggraini', 'Gunawan Wibowo', 'Hesti Purnama', 'Iwan Setiawan', 'Joko Susilo'];
        $jabatans = ['Audit Manager', 'Senior Auditor', 'Auditor', 'Risk Manager', 'Risk Officer', 'Compliance Officer', 'IT Specialist', 'Finance Manager', 'Operation Manager', 'HSE Manager'];
        $userRoles = ['admin', 'audit_manager', 'auditor', 'auditor', 'risk_manager', 'risk_officer', 'user', 'user', 'user', 'user'];
        $userData = [];
        foreach ($userNames as $i => $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@audit-app.com';
            $userData[] = [
                'name' => $name, 'email' => $email, 'password' => Hash::make('password123'),
                'business_unit_id' => $bu1,
                'nip' => '19900' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'jabatan' => $jabatans[$i], 'role' => $userRoles[$i],
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('users')->insert($userData);
        $userIds = DB::table('users')->pluck('id')->toArray();
        $user1 = $userIds[0];

        // ============ AUDIT PLANS (10) ============
        $planNames = ['Annual Procurement Audit', 'Financial Statements Audit', 'IT Security Audit', 'Operational Efficiency Audit', 'Compliance Audit', 'HR Process Audit', 'Supply Chain Audit', 'Asset Verification Audit', 'Budget Execution Audit', 'Risk Management Audit'];
        $periodes = ['Q1', 'Q2', 'Q3', 'Q4', 'Semester 1', 'Semester 2', 'Tahunan', 'Q1', 'Q2', 'Q3'];
        $statuses = ['disetujui', 'disetujui', 'disetujui', 'disetujui', 'draft', 'disetujui', 'draft', 'selesai', 'disetujui', 'draft'];
        $planData = [];
        foreach ($planNames as $i => $name) {
            $year = 2025;
            $startMonth = ($i % 4) * 3 + 1;
            $endMonth = $startMonth + 2;
            $startDay = str_pad(($i % 28) + 1, 2, '0', STR_PAD_LEFT);
            $endDay = str_pad((($i % 28) + 28), 2, '0', STR_PAD_LEFT);
            if ($endDay > 30) $endDay = 30;
            $planData[] = [
                'kode' => 'AP-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name, 'deskripsi' => 'Audit plan: ' . $name,
                'tahun' => $year, 'periode' => $periodes[$i],
                'tanggal_mulai' => "{$year}-" . str_pad($startMonth, 2, '0', STR_PAD_LEFT) . "-01",
                'tanggal_selesai' => "{$year}-" . str_pad(min($endMonth, 12), 2, '0', STR_PAD_LEFT) . "-{$endDay}",
                'anggaran' => rand(50, 300) * 1000000,
                'status' => $statuses[$i], 'created_by' => $user1,
                'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('audit_plans')->insert($planData);
        $planIds = DB::table('audit_plans')->pluck('id')->toArray();

        // ============ AUDIT UNIVERSES (10) ============
        $universeNames = ['Procurement Process', 'Financial Reporting', 'ERP System', 'Payroll & Compensation', 'Inventory Management', 'Vendor Management', 'Cash Management', 'Fixed Assets', 'Data Security', 'Contract Management'];
        $universeTypes = ['operasional', 'keuangan', 'teknologi_informasi', 'kepatuhan', 'operasional', 'operasional', 'keuangan', 'keuangan', 'teknologi_informasi', 'kepatuhan'];
        $riskLevels = ['high', 'critical', 'critical', 'medium', 'high', 'high', 'high', 'medium', 'critical', 'medium'];
        $universeData = [];
        foreach ($universeNames as $i => $name) {
            $universeData[] = [
                'kode' => 'AU-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name, 'deskripsi' => 'Audit universe: ' . $name,
                'departemen_id' => $deptIds[$i % count($deptIds)],
                'tipe' => $universeTypes[$i], 'risk_level' => $riskLevels[$i],
                'status' => 'active',
                'last_audit_date' => $i % 3 == 0 ? null : date('Y-m-d', strtotime("-{$i} months")),
                'audit_frequency_months' => [6, 12, 12, 12, 6, 12, 6, 12, 12, 12][$i],
                'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('audit_universes')->insert($universeData);
        $universeIds = DB::table('audit_universes')->pluck('id')->toArray();

        // ============ PELAKSANAAN AUDITS (10) ============
        $paStatuses = ['completed', 'completed', 'in_progress', 'in_progress', 'not_started', 'completed', 'completed', 'in_progress', 'not_started', 'cancelled'];
        $paData = [];
        foreach ($universeIds as $i => $auId) {
            $startMon = str_pad(($i % 12) + 1, 2, '0', STR_PAD_LEFT);
            $endMon = str_pad((($i % 12) + 2), 2, '0', STR_PAD_LEFT);
            if ($endMon > 12) $endMon = '12';
            $paData[] = [
                'kode' => 'PA-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'audit_plan_id' => $planIds[$i % count($planIds)],
                'audit_universe_id' => $auId,
                'auditor_id' => $userIds[$i % count($userIds)],
                'tanggal_mulai' => "2025-{$startMon}-01",
                'tanggal_selesai' => $paStatuses[$i] == 'completed' ? "2025-{$endMon}-28" : null,
                'status' => $paStatuses[$i],
                'temuan_sementara' => $paStatuses[$i] == 'completed' ? 'Audit completed with findings documented' : null,
                'realisasi_anggaran' => rand(20, 150) * 1000000,
                'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('pelaksanaan_audits')->insert($paData);
        $paIds = DB::table('pelaksanaan_audits')->pluck('id')->toArray();

        // ============ TEMUAN AUDITS (10) ============
        $temuanJuduls = ['Incomplete tender documentation', 'Vendor verification overdue', 'Bank reconciliation discrepancy', 'Unrecorded fixed assets', 'Unstructured onboarding process', 'Weak password policy', 'Missing approval signatures', 'Expired contracts not renewed', 'Data backup gap', 'Segregation of duties violation'];
        $severities = ['high', 'critical', 'high', 'medium', 'medium', 'critical', 'high', 'medium', 'high', 'critical'];
        $tipes = ['ketidaksesuaian', 'pelanggaran', 'ketidaksesuaian', 'observasi', 'peluang_perbaikan', 'pelanggaran', 'ketidaksesuaian', 'observasi', 'ketidaksesuaian', 'pelanggaran'];
        $temuanStatuses = ['open', 'in_progress', 'open', 'closed', 'overdue', 'open', 'in_progress', 'open', 'closed', 'in_progress'];
        $rootCauses = ['Lack of oversight', 'No verification schedule', 'Human error', 'Procedure not followed', 'No SOP', 'Policy gap', 'Approval bottleneck', 'Tracking gap', 'Backup policy gap', 'Role conflict'];
        $rootCats = ['Process', 'Policy', 'Human Error', 'Process', 'Policy', 'Technology', 'Process', 'Process', 'Technology', 'Process'];
        $temuanData = [];
        foreach ($temuanJuduls as $i => $judul) {
            $day = str_pad(($i + 5), 2, '0', STR_PAD_LEFT);
            if ($day > 28) $day = '28';
            $mon = str_pad(($i + 1), 2, '0', STR_PAD_LEFT);
            if ($mon > 12) $mon = '12';
            $temuanData[] = [
                'kode' => 'TA-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'pelaksanaan_audit_id' => $paIds[$i % count($paIds)],
                'departemen_id' => $deptIds[$i % count($deptIds)],
                'judul' => $judul, 'deskripsi' => 'Detailed finding: ' . $judul,
                'severity' => $severities[$i], 'tipe' => $tipes[$i],
                'rekomendasi' => 'Recommended action for: ' . $judul,
                'tanggal_temuan' => "2025-{$mon}-{$day}",
                'status' => $temuanStatuses[$i],
                'target_closure' => date('Y-m-d', strtotime("+3 months", strtotime("2025-{$mon}-{$day}"))),
                'actual_closure' => $temuanStatuses[$i] == 'closed' ? date('Y-m-d', strtotime("+2 months", strtotime("2025-{$mon}-{$day}"))) : null,
                'root_cause' => $rootCauses[$i], 'root_cause_category' => $rootCats[$i],
                'assigned_to' => $userIds[$i % count($userIds)],
                'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('temuan_audits')->insert($temuanData);
        $temuanIds = DB::table('temuan_audits')->pluck('id')->toArray();

        // ============ TINDAK LANJUTS (10) ============
        $tlDeskripsis = ['Create checklist for tender docs', 'Verify all registered vendors', 'Weekly bank reconciliation schedule', 'Conduct fixed asset stocktake', 'Develop onboarding SOP & modules', 'Enforce strong password policy', 'Streamline approval workflow', 'Set up contract renewal tracking', 'Implement automated daily backups', 'Redesign role-based access control'];
        $tlStatuses = ['completed', 'in_progress', 'open', 'verified', 'overdue', 'open', 'in_progress', 'open', 'completed', 'in_progress'];
        $tlData = [];
        foreach ($tlDeskripsis as $i => $desc) {
            $day = str_pad(($i + 1), 2, '0', STR_PAD_LEFT);
            $mon = str_pad(($i % 6) + 1, 2, '0', STR_PAD_LEFT);
            $tlData[] = [
                'temuan_audit_id' => $temuanIds[$i % count($temuanIds)],
                'deskripsi' => $desc,
                'tanggal_rencana' => "2025-{$mon}-{$day}",
                'tanggal_selesai' => in_array($tlStatuses[$i], ['completed', 'verified']) ? "2025-" . str_pad($mon + 1 > 12 ? 12 : $mon + 1, 2, '0', STR_PAD_LEFT) . "-{$day}" : null,
                'status' => $tlStatuses[$i],
                'penanggung_jawab_id' => $userIds[$i % count($userIds)],
                'bukti' => in_array($tlStatuses[$i], ['completed', 'verified']) ? 'Evidence document attached' : null,
                'catatan_verifikasi' => $tlStatuses[$i] == 'verified' ? 'Verified and approved' : null,
                'verified_by' => $tlStatuses[$i] == 'verified' ? $user1 : null,
                'verified_at' => $tlStatuses[$i] == 'verified' ? $now : null,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('tindak_lanjuts')->insert($tlData);

        // ============ RISK REGISTERS (10) ============
        $riskNames = ['Vendor failure risk', 'Currency fluctuation risk', 'Cyber attack risk', 'Regulatory non-compliance risk', 'Supply chain disruption risk', 'Key person dependency risk', 'Data breach risk', 'Fraud risk', 'Business continuity risk', 'Reputation damage risk'];
        $impactScores = [4, 3, 5, 4, 3, 4, 5, 3, 4, 3];
        $probScores = [3, 4, 3, 2, 3, 3, 2, 4, 2, 3];
        $riskStatuses = ['assessed', 'treated', 'assessed', 'identified', 'monitored', 'assessed', 'identified', 'treated', 'identified', 'monitored'];
        $riskData = [];
        foreach ($riskNames as $i => $name) {
            $score = $impactScores[$i] * $probScores[$i];
            $level = $score >= 20 ? 'critical' : ($score >= 15 ? 'high' : ($score >= 8 ? 'medium' : 'low'));
            $day = str_pad(($i + 1), 2, '0', STR_PAD_LEFT);
            $mon = str_pad(($i % 6) + 1, 2, '0', STR_PAD_LEFT);
            $riskData[] = [
                'kode' => 'RR-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name, 'deskripsi' => 'Description: ' . $name,
                'departemen_id' => $deptIds[$i % count($deptIds)],
                'kategori_risiko_id' => $katIds[$i % count($katIds)],
                'impact_score' => $impactScores[$i], 'probability_score' => $probScores[$i],
                'risk_score' => $score, 'risk_level' => $level,
                'penyebab' => 'Root cause: ' . $name, 'dampak' => 'Impact: ' . $name,
                'mitigasi' => 'Mitigation: ' . $name,
                'status' => $riskStatuses[$i],
                'risk_owner_id' => $userIds[$i % count($userIds)],
                'tanggal_identifikasi' => "2025-{$mon}-{$day}",
                'tanggal_review' => $i % 2 == 0 ? date('Y-m-d', strtotime("+6 months", strtotime("2025-{$mon}-{$day}"))) : null,
                'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('risk_registers')->insert($riskData);
        $riskIds = DB::table('risk_registers')->pluck('id')->toArray();

        // ============ KEY RISK INDICATORS (10) ============
        $kriNames = ['Active vendor count', 'FX hedging ratio', 'Security incident count', 'Compliance training completion', 'On-time delivery rate', 'Backup success rate', 'System uptime %', 'Audit finding closure rate', 'Budget variance %', 'Employee turnover rate'];
        $kriStatuses = ['green', 'yellow', 'red', 'green', 'yellow', 'green', 'green', 'yellow', 'red', 'green'];
        $frekuensis = ['bulanan', 'harian', 'mingguan', 'triwulan', 'bulanan', 'harian', 'harian', 'bulanan', 'triwulan', 'semesteran'];
        $kriData = [];
        foreach ($kriNames as $i => $name) {
            $kriData[] = [
                'kode' => 'KRI-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name, 'deskripsi' => 'KRI: ' . $name,
                'risk_register_id' => $riskIds[$i % count($riskIds)],
                'departemen_id' => $deptIds[$i % count($deptIds)],
                'target' => rand(80, 100), 'current_value' => rand(60, 105),
                'threshold_min' => 70, 'threshold_max' => 100,
                'satuan' => ['vendor', '%', 'count', '%', '%', '%', '%', '%', '%', '%'][$i],
                'status' => $kriStatuses[$i], 'frekuensi' => $frekuensis[$i],
                'last_update' => date('Y-m-d', strtotime("-{$i} days")),
                'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('key_risk_indicators')->insert($kriData);

        // ============ RISK MONITORINGS (10) ============
        $rmData = [];
        foreach ($riskIds as $i => $rrId) {
            $imp = rand(2, 5); $prob = rand(2, 5);
            $score = $imp * $prob;
            $level = $score >= 20 ? 'critical' : ($score >= 15 ? 'high' : ($score >= 8 ? 'medium' : 'low'));
            $mon = str_pad(($i % 12) + 1, 2, '0', STR_PAD_LEFT);
            $rmData[] = [
                'risk_register_id' => $rrId,
                'tanggal' => "2025-{$mon}-15",
                'impact_score' => $imp, 'probability_score' => $prob,
                'risk_score' => $score, 'risk_level' => $level,
                'catatan' => 'Monitoring note for risk #' . ($i + 1),
                'tindakan' => $i % 2 == 0 ? 'Continue monitoring' : 'Mitigation in progress',
                'reported_by' => $userIds[$i % count($userIds)],
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('risk_monitorings')->insert($rmData);

        // ============ BUDGET COAS (10) ============
        $budgetNames = ['Revenue - Product Sales', 'Revenue - Services', 'Expense - Salaries', 'Expense - Operational', 'Asset - Equipment', 'Liability - Tax Payable', 'Equity - Retained Earnings', 'Expense - Marketing', 'Revenue - Rental Income', 'Expense - Maintenance'];
        $budgetTypes = ['pendapatan', 'pendapatan', 'beban', 'beban', 'aset', 'kewajiban', 'ekuitas', 'beban', 'pendapatan', 'beban'];
        $budgetPeriodes = ['Tahunan', 'Q1', 'Tahunan', 'Q2', 'Tahunan', 'Q1', 'Tahunan', 'Q3', 'Q4', 'Tahunan'];
        $budgetData = [];
        foreach ($budgetNames as $i => $name) {
            $anggaran = rand(50, 500) * 1000000;
            $realisasi = $budgetPeriodes[$i] == 'Tahunan' ? rand(100, 400) * 1000000 : rand(20, 150) * 1000000;
            $budgetData[] = [
                'kode_coa' => 'BC-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $name, 'tipe' => $budgetTypes[$i],
                'departemen_id' => $i % 2 == 0 ? $deptIds[$i % count($deptIds)] : null,
                'anggaran' => $anggaran, 'realisasi' => $realisasi,
                'tahun' => 2025, 'periode' => $budgetPeriodes[$i],
                'keterangan' => 'Budget: ' . $name,
                'business_unit_id' => $bu1,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('budget_coas')->insert($budgetData);

        // Final counts
        echo "=== Seed Complete ===" . PHP_EOL;
        foreach (['business_units', 'roles', 'departemens', 'kategori_risikos', 'kriteria_penilaians', 'users', 'audit_plans', 'audit_universes', 'pelaksanaan_audits', 'temuan_audits', 'tindak_lanjuts', 'risk_registers', 'key_risk_indicators', 'risk_monitorings', 'budget_coas'] as $t) {
            echo $t . ': ' . DB::table($t)->count() . PHP_EOL;
        }
    }
}
