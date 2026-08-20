@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Laporan</h2><p class="text-sm text-slate-500 mt-0.5">Dashboard laporan dan ringkasan audit & risiko</p></div>
</div>
<div class="grid grid-cols-4 gap-4 mb-5">
    <div class="card p-5 flex items-center gap-4"><div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center"><svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg></div><div><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Temuan</div><div class="text-2xl font-extrabold text-slate-900">{{ $totalFindings }}</div></div></div>
    <div class="card p-5 flex items-center gap-4"><div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><div><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tindak Lanjut</div><div class="text-2xl font-extrabold text-slate-900">{{ $totalTindakLanjut }}</div></div></div>
    <div class="card p-5 flex items-center gap-4"><div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center"><svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg></div><div><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Risiko</div><div class="text-2xl font-extrabold text-slate-900">{{ $totalRisks }}</div></div></div>
    <div class="card p-5 flex items-center gap-4"><div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div><div><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Audit</div><div class="text-2xl font-extrabold text-slate-900">{{ $totalAudit }}</div></div></div>
</div>
<div class="grid grid-cols-2 gap-5 mb-5">
    <div class="card p-6">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Temuan Berdasarkan Severity</h3>
        <canvas id="severityChart" height="220"></canvas>
    </div>
    <div class="card p-6">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Risiko Berdasarkan Level</h3>
        <canvas id="riskLevelChart" height="220"></canvas>
    </div>
    <div class="card p-6">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Status Tindak Lanjut</h3>
        <canvas id="tindakLanjutChart" height="220"></canvas>
    </div>
    <div class="card p-6">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Ringkasan Anggaran</h3>
        @if($budgetSummary)
        <div class="space-y-3">
            <div class="flex justify-between items-center"><span class="text-xs text-slate-500">Total Anggaran</span><span class="text-sm font-bold text-slate-900">Rp {{ number_format($budgetSummary['total_anggaran'] ?? 0, 0, ',', '.') }}</span></div>
            <div class="flex justify-between items-center"><span class="text-xs text-slate-500">Total Realisasi</span><span class="text-sm font-bold text-blue-600">Rp {{ number_format($budgetSummary['total_realisasi'] ?? 0, 0, ',', '.') }}</span></div>
            <div class="flex justify-between items-center"><span class="text-xs text-slate-500">Sisa</span><span class="text-sm font-bold {{ ($budgetSummary['sisa'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-red-600' }}">Rp {{ number_format($budgetSummary['sisa'] ?? 0, 0, ',', '.') }}</span></div>
            <div class="w-full bg-slate-100 rounded-full h-2.5 mt-2"><div class="bg-primary-500 h-2.5 rounded-full" style="width: {{ $budgetSummary['persen'] ?? 0 }}%"></div></div>
            <div class="text-xs text-slate-400 text-right">{{ $budgetSummary['persen'] ?? 0 }}% realisasi</div>
        </div>
        @else
        <div class="text-center text-slate-400 py-8 text-sm">Belum ada data anggaran</div>
        @endif
    </div>
</div>
<div class="card overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100"><h3 class="text-sm font-bold text-slate-900">Top 5 Departemen dengan Temuan Terbanyak</h3></div>
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">#</th><th class="text-left px-6 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Departemen</th><th class="text-center px-6 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jumlah Temuan</th><th class="text-left px-6 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Severity</th></tr></thead>
        <tbody>
            @forelse($findingsByDept as $i => $fd)
            <tr class="table-row">
                <td class="px-6 py-3 font-semibold text-slate-900">{{ $i + 1 }}</td>
                <td class="px-6 py-3">{{ $fd['departemen'] }}</td>
                <td class="px-6 py-3 text-center font-bold">{{ $fd['total'] }}</td>
                <td class="px-6 py-3"><span class="badge {{ $fd['severity'] == 'critical' ? 'badge-red' : ($fd['severity'] == 'high' ? 'badge-orange' : ($fd['severity'] == 'medium' ? 'badge-yellow' : 'badge-green')) }}">{{ ucfirst($fd['severity']) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var svLabels = @json(array_keys($findingsBySeverity));
    var svData = @json(array_values($findingsBySeverity));
    var svColors = { low: '#22c55e', medium: '#eab308', high: '#f97316', critical: '#ef4444' };
    var svBg = svLabels.map(function(l) { return svColors[l] || '#6366f1'; });
    new Chart(document.getElementById('severityChart'), {
        type: 'bar',
        data: { labels: svLabels.map(function(l) { return l.charAt(0).toUpperCase() + l.slice(1); }), datasets: [{ data: svData, backgroundColor: svBg, borderRadius: 8 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    var rlLabels = @json(array_keys($risksByLevel));
    var rlData = @json(array_values($risksByLevel));
    var rlColors = { Low: '#22c55e', Medium: '#eab308', High: '#f97316', Critical: '#ef4444' };
    var rlBg = rlLabels.map(function(l) { return rlColors[l] || '#6366f1'; });
    new Chart(document.getElementById('riskLevelChart'), {
        type: 'doughnut',
        data: { labels: rlLabels, datasets: [{ data: rlData, backgroundColor: rlBg, borderWidth: 0 }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 15, font: { size: 11 } } } } }
    });

    var tlLabels = @json(array_keys($tindakLanjutByStatus));
    var tlData = @json(array_values($tindakLanjutByStatus));
    var tlColors = { open: '#eab308', in_progress: '#3b82f6', completed: '#22c55e', overdue: '#ef4444', verified: '#7c3aed' };
    var tlBg = tlLabels.map(function(l) { return tlColors[l] || '#6366f1'; });
    new Chart(document.getElementById('tindakLanjutChart'), {
        type: 'bar',
        data: { labels: tlLabels.map(function(l) { return l.replace(/_/g, ' ').replace(/\b\w/g, function(c) { return c.toUpperCase(); }); }), datasets: [{ data: tlData, backgroundColor: tlBg, borderRadius: 8 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
});
</script>
@endpush