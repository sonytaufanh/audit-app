@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Risk Heat Map</h2><p class="text-sm text-slate-500 mt-0.5">Visualisasi pemetaan risiko berdasarkan impact dan probability</p></div>
</div>
<div class="flex gap-6">
    <div class="flex-1">
        <div class="card p-6">
            <div class="grid grid-cols-5 gap-3">
                @php
                $heatData = [];
                for ($i = 5; $i >= 1; $i--) {
                    for ($j = 1; $j <= 5; $j++) {
                        $heatData[$i][$j] = $risks->filter(function($r) use ($i, $j) { return $r['impact'] == $i && $r['probability'] == $j; })->count();
                    }
                }
                $colors = [
                    1 => ['bg-green-100 text-green-700','bg-green-100 text-green-700','bg-yellow-100 text-yellow-700','bg-orange-100 text-orange-700','bg-orange-100 text-orange-700'],
                    2 => ['bg-green-100 text-green-700','bg-yellow-100 text-yellow-700','bg-yellow-100 text-yellow-700','bg-orange-100 text-orange-700','bg-red-100 text-red-700'],
                    3 => ['bg-yellow-100 text-yellow-700','bg-yellow-100 text-yellow-700','bg-orange-100 text-orange-700','bg-orange-100 text-orange-700','bg-red-100 text-red-700'],
                    4 => ['bg-yellow-100 text-yellow-700','bg-orange-100 text-orange-700','bg-orange-100 text-orange-700','bg-red-100 text-red-700','bg-red-100 text-red-700'],
                    5 => ['bg-orange-100 text-orange-700','bg-orange-100 text-orange-700','bg-red-100 text-red-700','bg-red-100 text-red-700','bg-red-100 text-red-700'],
                ];
                @endphp
                <div class="flex items-center justify-center text-[11px] font-bold text-slate-400"></div>
                @for ($p = 1; $p <= 5; $p++)
                <div class="flex items-center justify-center text-[11px] font-bold text-slate-400">P{{ $p }}</div>
                @endfor
                @for ($i = 5; $i >= 1; $i--)
                <div class="flex items-center justify-center text-[11px] font-bold text-slate-400">I{{ $i }}</div>
                @for ($j = 1; $j <= 5; $j++)
                @php $count = $heatData[$i][$j]; $color = $colors[$i][$j-1]; @endphp
                <div class="rounded-xl {{ $color }} p-4 text-center min-h-[80px] flex flex-col items-center justify-center border border-transparent hover:border-slate-300 transition cursor-pointer">
                    <div class="text-2xl font-extrabold">{{ $count }}</div>
                    <div class="text-[10px] font-semibold mt-1">risk</div>
                </div>
                @endfor
                @endfor
            </div>
            <div class="flex justify-center gap-6 mt-6 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500"><span class="w-3 h-3 rounded bg-green-100"></span> Low</div>
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500"><span class="w-3 h-3 rounded bg-yellow-100"></span> Medium</div>
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500"><span class="w-3 h-3 rounded bg-orange-100"></span> High</div>
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500"><span class="w-3 h-3 rounded bg-red-100"></span> Critical</div>
            </div>
        </div>
    </div>
    <div class="w-[320px]">
        <div class="card overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100"><h3 class="text-sm font-bold text-slate-900">Daftar Risiko</h3></div>
            <div class="max-h-[500px] overflow-y-auto">
                @forelse($risks as $r)
                @php
                $score = $r['impact'] * $r['probability'];
                $cls = $score >= 15 ? 'badge-red' : ($score >= 10 ? 'badge-orange' : ($score >= 5 ? 'badge-yellow' : 'badge-green'));
                $lvl = $score >= 15 ? 'Critical' : ($score >= 10 ? 'High' : ($score >= 5 ? 'Medium' : 'Low'));
                @endphp
                <div class="px-5 py-3 border-b border-slate-50 hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-slate-900">{{ $r['kode'] }}</span>
                        <span class="badge {{ $cls }}">{{ $lvl }}</span>
                    </div>
                    <div class="text-xs text-slate-500 truncate">{{ $r['nama'] }}</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $r['departemen'] ?? '-' }} | I{{ $r['impact'] }} P{{ $r['probability'] }} = {{ $score }}</div>
                </div>
                @empty
                <div class="px-5 py-10 text-center text-slate-400 text-sm">Belum ada data risiko</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection