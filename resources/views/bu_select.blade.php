@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="text-center mb-10">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 mx-auto flex items-center justify-center shadow-lg shadow-primary-500/25 mb-5">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-slate-900">Pilih Business Unit</h2>
        <p class="text-sm text-slate-500 mt-1">Silakan pilih business unit untuk melanjutkan</p>
    </div>

    <div class="space-y-3">
        @forelse($businessUnits as $bu)
        <form action="{{ route('bu.select') }}" method="POST" class="card p-5 hover:border-primary-300 hover:shadow-md transition-all cursor-pointer group flex items-center justify-between" onclick="this.submit()">
            @csrf
            <input type="hidden" name="business_unit_id" value="{{ $bu->id }}">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-100 to-primary-50 flex items-center justify-center text-primary-600 font-bold text-sm group-hover:from-primary-200 group-hover:to-primary-100 transition">{{ substr($bu->kode, 0, 2) }}</div>
                <div>
                    <div class="font-bold text-slate-900 group-hover:text-primary-600 transition">{{ $bu->nama }}</div>
                    <div class="text-xs text-slate-400 font-medium">{{ $bu->kode }} @if($bu->lokasi) · {{ $bu->lokasi }} @endif</div>
                </div>
            </div>
            <svg class="w-5 h-5 text-slate-300 group-hover:text-primary-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </form>
        @empty
        <div class="card p-12 text-center">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
            <div class="text-slate-400 font-medium">Belum ada business unit.</div>
            <a href="{{ route('master.business-unit.index') }}" class="btn-primary inline-block mt-5">Tambah Business Unit</a>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-slate-400 hover:text-primary-600 font-medium transition">Lewati untuk sekarang →</a>
    </div>
</div>
@endsection