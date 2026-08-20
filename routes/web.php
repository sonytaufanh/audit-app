<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KategoriRisikoController;
use App\Http\Controllers\KriteriaPenilaianController;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditPlanController;
use App\Http\Controllers\AuditUniverseController;
use App\Http\Controllers\PelaksanaanAuditController;
use App\Http\Controllers\TemuanAuditController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\RiskRegisterController;
use App\Http\Controllers\KeyRiskIndicatorController;
use App\Http\Controllers\RiskMonitoringController;
use App\Http\Controllers\BudgetCoaController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Business Unit Selection
Route::get('/pilih-bu', function () {
    try {
        $businessUnits = \App\Models\BusinessUnit::where('is_active', true)->orderBy('nama')->get();
    } catch (\Exception $e) {
        $businessUnits = collect();
    }
    return view('bu_select', compact('businessUnits'));
})->name('bu.select.form');

Route::post('/pilih-bu', function (Request $request) {
    $request->validate(['business_unit_id' => 'required|exists:business_units,id']);
    session(['active_business_unit_id' => $request->business_unit_id]);
    $bu = \App\Models\BusinessUnit::find($request->business_unit_id);
    session(['active_business_unit_name' => $bu->nama]);
    return redirect()->route('dashboard')->with('success', 'Business Unit: ' . $bu->nama);
})->name('bu.select');

// Master Data
Route::prefix('master')->name('master.')->group(function () {
    Route::resource('departemen', DepartemenController::class)->except(['show', 'create', 'edit'])->parameter('departemen', 'departemen');
    Route::resource('kategori-risiko', KategoriRisikoController::class)->except(['show', 'create', 'edit'])->parameter('kategori-risiko', 'kategoriRisiko');
    Route::resource('kriteria', KriteriaPenilaianController::class)->except(['show', 'create', 'edit'])->parameter('kriteria', 'kriteriaPenilaian');
    Route::resource('business-unit', BusinessUnitController::class)->except(['show', 'create', 'edit'])->parameter('business-unit', 'businessUnit');
    Route::resource('role', RoleController::class)->except(['show', 'create', 'edit']);
    Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
    Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
});

// Audit Management
Route::prefix('audit')->name('audit.')->group(function () {
    Route::resource('plan', AuditPlanController::class)->except(['show', 'create', 'edit'])->parameter('plan', 'auditPlan');
    Route::resource('universe', AuditUniverseController::class)->except(['show', 'create', 'edit'])->parameter('universe', 'auditUniverse');
    Route::resource('pelaksanaan', PelaksanaanAuditController::class)->except(['show', 'create', 'edit'])->parameter('pelaksanaan', 'pelaksanaanAudit');
    Route::resource('temuan', TemuanAuditController::class)->except(['show', 'create', 'edit'])->parameter('temuan', 'temuanAudit');
    Route::resource('tindak-lanjut', TindakLanjutController::class)->except(['show', 'create', 'edit'])->parameter('tindak-lanjut', 'tindakLanjut');
});

// Risk Management
Route::prefix('risk')->name('risk.')->group(function () {
    Route::get('heatmap', [RiskRegisterController::class, 'heatMap'])->name('heatmap');
    Route::resource('register', RiskRegisterController::class)->except(['show', 'create', 'edit'])->parameter('register', 'riskRegister');
    Route::resource('kri', KeyRiskIndicatorController::class)->except(['show', 'create', 'edit'])->parameter('kri', 'keyRiskIndicator');
    Route::resource('monitoring', RiskMonitoringController::class)->except(['show', 'create', 'edit'])->parameter('monitoring', 'riskMonitoring');
});

// Analytics & Report
Route::prefix('analytics')->name('budget.')->group(function () {
    Route::resource('budget-coa', BudgetCoaController::class)->except(['show', 'create', 'edit'])->parameter('budget-coa', 'budgetCoa');
});
Route::get('laporan', [LaporanController::class, 'index'])->name('laporan');