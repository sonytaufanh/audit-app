@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-[22px] font-bold text-slate-900">Dashboard Overview</h2>
        <p class="text-sm text-slate-500 mt-0.5">Pantau audit, risiko, dan rekomendasi secara real-time</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative">
            <input type="text" placeholder="Cari..." class="input-field w-auto w-56 pl-9">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <select class="input-field w-auto"><option>2025</option><option>2026</option><option>2027</option></select>
        <select class="input-field w-auto"><option>Q2 (Apr - Jun)</option><option>Q1 (Jan - Mar)</option><option>Q3 (Jul - Sep)</option><option>Q4 (Oct - Dec)</option></select>
        <button class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export
        </button>
    </div>
</div>

{{-- KPI ROW 1 --}}
<div class="grid grid-cols-6 gap-4 mb-5">
    @php
        $cards = [
            ['TOTAL OBJEK AUDIT', $dashboard['total_audit'], 'Dari 12 rencana', 'from-indigo-500 to-indigo-600', 'bg-indigo-50 text-indigo-600'],
            ['SEDANG BERJALAN', $dashboard['running_audit'], 'sedang audit', 'from-blue-500 to-blue-600', 'bg-blue-50 text-blue-600'],
            ['SELESAI', $dashboard['completed_audit'], 'audit selesai', 'from-emerald-500 to-emerald-600', 'bg-emerald-50 text-emerald-600'],
            ['BELUM MULAI', $dashboard['not_started'], 'menunggu', 'from-slate-500 to-slate-600', 'bg-slate-50 text-slate-600'],
            ['TOTAL BUDGET', 'Rp ' . number_format($dashboard['total_budget'] ?? 0, 0, ',', '.'), 'Anggaran 2025', 'from-amber-500 to-amber-600', 'bg-amber-50 text-amber-600'],
            ['REALISASI YTD', 'Rp ' . number_format($dashboard['total_realisasi'] ?? 0, 0, ',', '.'), 'terealisasi', 'from-rose-500 to-rose-600', 'bg-rose-50 text-rose-600'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="card p-5 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br {{ $card[3] }} opacity-[0.06] rounded-bl-full"></div>
        <div class="text-[10px] font-bold text-slate-400 tracking-wider">{{ $card[0] }}</div>
        <div class="text-[26px] font-extrabold text-slate-900 mt-2 tracking-tight">{{ $card[1] }}</div>
        <div class="text-xs text-slate-400 mt-1 font-medium">{{ $card[2] }}</div>
    </div>
    @endforeach
</div>

{{-- KPI ROW 2 --}}
<div class="grid grid-cols-6 gap-4 mb-6">
    @php
        $cards2 = [
            ['TOTAL AUDIT FINDING', $dashboard['total_findings'], 'text-red-600', 'bg-red-50'],
            ['HIGH RISK FINDING', $dashboard['high_risk'], 'text-orange-600', 'bg-orange-50'],
            ['OVERDUE CAPA', $dashboard['overdue_capa'], 'text-rose-600', 'bg-rose-50'],
            ['OPEN RECOMMENDATION', $dashboard['open_recommendation'], 'text-blue-600', 'bg-blue-50'],
            ['CLOSED RECOMMENDATION', $dashboard['closed_recommendation'], 'text-emerald-600', 'bg-emerald-50'],
            ['AVG CLOSURE TIME', $dashboard['avg_closure_days'] . ' hari', 'text-purple-600', 'bg-purple-50'],
        ];
    @endphp
    @foreach($cards2 as $card)
    <div class="card p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $card[3] }} flex items-center justify-center">
                <span class="font-bold text-sm {{ $card[2] }}">{{ is_numeric($card[1]) ? $card[1] : substr($card[1], 0, 2) }}</span>
            </div>
            <div>
                <div class="text-[10px] font-bold text-slate-400 tracking-wider">{{ $card[0] }}</div>
                <div class="text-lg font-bold text-slate-900">{{ $card[1] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- CHARTS --}}
<div class="grid grid-cols-2 gap-5 mb-5">
    <div class="card p-6">
        <div class="mb-5">
            <h3 class="font-bold text-slate-900">Risk Heat Map</h3>
            <p class="text-xs text-slate-400 mt-0.5">Key risk berdasarkan impact dan probability</p>
        </div>
        <div class="space-y-1.5">
            @for($row = 5; $row >= 1; $row--)
            <div class="grid grid-cols-5 gap-1.5">
                @for($col = 1; $col <= 5; $col++)
                    @php
                        $bg = ($row >= 4 && $col >= 4) ? 'bg-red-100 text-red-600 border-red-200' :
                              (($row >= 3 && $col >= 3) ? 'bg-orange-100 text-orange-600 border-orange-200' :
                              (($row >= 2 && $col >= 2) ? 'bg-yellow-100 text-yellow-600 border-yellow-200' :
                              'bg-emerald-50 text-emerald-600 border-emerald-200'));
                        $i = ($row - 1) * 5 + $col;
                    @endphp
                    <div class="h-12 rounded-lg flex items-center justify-center text-[10px] font-bold border {{ $bg }}">
                        @if(in_array($i, [7, 13, 17, 19, 21, 23, 25])) R{{ $i }} @endif
                    </div>
                @endfor
            </div>
            @endfor
        </div>
        <div class="flex justify-between text-[10px] text-slate-400 mt-3 px-1 font-medium">
            <span>Low</span><span>Probability</span><span>High</span>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-bold text-slate-900">Temuan per Departemen</h3>
        <p class="text-xs text-slate-400 mt-0.5 mb-5">Distribusi berdasarkan severity</p>
        <canvas id="departmentChart" height="160"></canvas>
    </div>
</div>

{{-- BOTTOM --}}
<div class="grid grid-cols-3 gap-5">
    <div class="card p-6">
        <h3 class="font-bold text-slate-900">Department Risk Ranking</h3>
        <p class="text-xs text-slate-400 mt-0.5 mb-5">Berdasarkan Risk Score</p>
        @foreach($riskRanking as $i => $rank)
        <div class="flex items-center justify-between px-4 py-3 rounded-xl mb-2 {{ $i === 0 ? 'bg-red-50 border border-red-100' : 'bg-slate-50' }}">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold {{ $i === 0 ? 'bg-red-100 text-red-600' : ($i === 1 ? 'bg-orange-100 text-orange-600' : 'bg-slate-200 text-slate-600') }}">{{ $i + 1 }}</span>
                <div>
                    <div class="font-semibold text-sm text-slate-900">{{ $rank['name'] }}</div>
                    <div class="text-xs text-slate-400">Risk Score</div>
                </div>
            </div>
            <div class="font-extrabold text-lg {{ $rank['score'] >= 18 ? 'text-red-500' : ($rank['score'] >= 15 ? 'text-orange-500' : 'text-emerald-500') }}">{{ $rank['score'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="card p-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-bold text-slate-900">AI Insight & Recommendation</h3>
                <p class="text-xs text-slate-400 mt-0.5">Analisis otomatis dari data audit</p>
            </div>
            <span class="badge badge-purple flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/></svg>
                AI
            </span>
        </div>
        <div class="mt-5 bg-red-50 border border-red-100 rounded-xl p-4">
            <div class="font-bold text-red-600 text-sm">🔴 {{ $riskRanking[0]['name'] ?? 'Procurement' }}</div>
            <div class="text-xs mt-3 space-y-2 text-slate-600">
                <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> {{ $dashboard['high_risk'] }} temuan High Risk</div>
                <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> {{ $dashboard['overdue_capa'] }} overdue recommendation</div>
                <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Risk Score: {{ $riskRanking[0]['score'] ?? 20 }}</div>
            </div>
        </div>
        <div class="mt-4">
            <div class="text-sm font-semibold text-slate-900">Rekomendasi:</div>
            <div class="text-xs text-slate-500 mt-3 space-y-2.5">
                <div class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5"></span> Penguatan vendor management</div>
                <div class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5"></span> Review approval & segregation</div>
                <div class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5"></span> Monitoring kontrak otomatis</div>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-bold text-slate-900">Top Root Cause</h3>
        <p class="text-xs text-slate-400 mt-0.5">Analisis akar penyebab temuan</p>
        <canvas id="rootCauseChart" class="mt-6"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('departmentChart'), {
    type: 'bar',
    data: {
        labels: ['Procurement', 'Finance', 'Operational', 'IT', 'Legal', 'HRGA', 'Marketing', 'Sales'],
        datasets: [
            { label: 'High', data: [2, 0, 2, 4, 1, 0, 1, 0], backgroundColor: '#ef4444', borderRadius: 6 },
            { label: 'Medium', data: [2, 1, 2, 0, 1, 0, 0, 0], backgroundColor: '#f97316', borderRadius: 6 },
            { label: 'Low', data: [0, 0, 2, 0, 0, 1, 0, 1], backgroundColor: '#22c55e', borderRadius: 6 }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 11 } } } },
        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
    }
});
new Chart(document.getElementById('rootCauseChart'), {
    type: 'doughnut',
    data: {
        labels: ['Human Error', 'Process', 'System', 'Policy'],
        datasets: [{ data: [40, 30, 15, 15], backgroundColor: ['#6366f1', '#f97316', '#22c55e', '#ef4444'], borderWidth: 0 }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 11 } } } }
    }
});
</script>
@endpush