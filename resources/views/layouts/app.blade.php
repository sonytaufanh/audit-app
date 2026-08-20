<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit & Risk Intelligence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#6366f1', 50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81' },
                        accent: { DEFAULT: '#06b6d4', 50: '#ecfeff', 500: '#06b6d4', 600: '#0891b2' },
                        surface: { DEFAULT: '#0f172a', 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 700: '#334155', 800: '#1e293b', 900: '#0f172a' }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background: #f8fafc; }

        .sidebar-link {
            display: flex; align-items: center; gap: 10px; padding: 8px 12px; margin-bottom: 1px;
            border-radius: 8px; font-size: 13px; font-weight: 500; color: #64748b;
            text-decoration: none; transition: all 0.15s ease; border-left: 2px solid transparent;
        }
        .sidebar-link:hover { background: #f1f5f9; color: #0f172a; }
        .sidebar-link.active { background: #f1f5f9; color: #6366f1; font-weight: 600; border-left-color: #6366f1; }
        .sidebar-link svg { width: 18px; height: 18px; flex-shrink: 0; }

        .btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; font-weight: 500; font-size: 13px; padding: 10px 20px; border-radius: 10px; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(99,102,241,0.25); }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #4338ca); box-shadow: 0 4px 12px rgba(99,102,241,0.35); transform: translateY(-1px); }

        .btn-secondary { background: #fff; border: 1px solid #e2e8f0; color: #475569; font-weight: 500; font-size: 13px; padding: 10px 20px; border-radius: 10px; transition: all 0.15s ease; }
        .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; }

        .card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: all 0.2s ease; }
        .card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }

        .input-field { width: 100%; border: 1px solid #e2e8f0; border-radius: 10px; padding: 9px 14px; font-size: 13px; transition: all 0.15s ease; background: #fff; }
        .input-field:focus { outline: none; border-color: #818cf8; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }

        .badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; letter-spacing: 0.01em; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-red { background: #fee2e2; color: #dc2626; }
        .badge-yellow { background: #fef9c3; color: #ca8a04; }
        .badge-blue { background: #dbeafe; color: #2563eb; }
        .badge-purple { background: #ede9fe; color: #7c3aed; }
        .badge-slate { background: #f1f5f9; color: #475569; }
        .badge-orange { background: #fff7ed; color: #ea580c; }

        .modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.5); backdrop-filter: blur(2px); display: none; align-items: center; justify-content: center; z-index: 100; }
        .modal-overlay.show { display: flex; }
        .modal-box { background: #fff; border-radius: 20px; width: 100%; max-width: 520px; box-shadow: 0 25px 50px rgba(0,0,0,0.15); animation: modalIn 0.2s ease; }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(8px); } to { opacity: 1; transform: scale(1) translateY(0); } }

        .table-row { border-bottom: 1px solid #f1f5f9; transition: background 0.1s ease; }
        .table-row:hover { background: #f8fafc; }

        .section-title { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; padding-left: 4px; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body class="text-slate-700 antialiased">

<div class="flex min-h-screen">

{{-- SIDEBAR --}}
    <aside class="w-[240px] bg-white border-r border-slate-200 fixed inset-y-0 overflow-y-auto z-40 flex flex-col">

        <a href="{{ route('dashboard') }}" class="h-[56px] px-5 flex items-center gap-3 border-b border-slate-100 shrink-0">
            <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center shadow-sm">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <span class="font-bold text-[15px] text-slate-900">Audit Risk</span>
        </a>

        <div class="flex-1 px-3 py-3 space-y-5">

            <div>
                <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5 px-3">Audit</div>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('audit.plan.index') }}" class="sidebar-link {{ request()->routeIs('audit.plan.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Audit Plan
                </a>
                <a href="{{ route('audit.universe.index') }}" class="sidebar-link {{ request()->routeIs('audit.universe.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/></svg>
                    Audit Universe
                </a>
                <a href="{{ route('audit.pelaksanaan.index') }}" class="sidebar-link {{ request()->routeIs('audit.pelaksanaan.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Pelaksanaan
                </a>
                <a href="{{ route('audit.temuan.index') }}" class="sidebar-link {{ request()->routeIs('audit.temuan.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    Temuan
                </a>
                <a href="{{ route('audit.tindak-lanjut.index') }}" class="sidebar-link {{ request()->routeIs('audit.tindak-lanjut.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Tindak Lanjut
                </a>
            </div>

            <div>
                <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5 px-3">Risk</div>
                <a href="{{ route('risk.heatmap') }}" class="sidebar-link {{ request()->routeIs('risk.heatmap') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Heat Map
                </a>
                <a href="{{ route('risk.register.index') }}" class="sidebar-link {{ request()->routeIs('risk.register.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Risk Register
                </a>
                <a href="{{ route('risk.kri.index') }}" class="sidebar-link {{ request()->routeIs('risk.kri.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    KRI
                </a>
                <a href="{{ route('risk.monitoring.index') }}" class="sidebar-link {{ request()->routeIs('risk.monitoring.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Monitoring
                </a>
            </div>

            <div>
                <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5 px-3">Report</div>
                <a href="{{ route('laporan') }}" class="sidebar-link {{ request()->routeIs('laporan') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan
                </a>
                <a href="{{ route('budget.budget-coa.index') }}" class="sidebar-link {{ request()->routeIs('budget.budget-coa.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Budget COA
                </a>
            </div>

            <div>
                <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5 px-3">Master Data</div>
                <a href="{{ route('master.business-unit.index') }}" class="sidebar-link {{ request()->routeIs('master.business-unit.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Business Unit
                </a>
                <a href="{{ route('master.role.index') }}" class="sidebar-link {{ request()->routeIs('master.role.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Role
                </a>
                <a href="{{ route('master.departemen.index') }}" class="sidebar-link {{ request()->routeIs('master.departemen.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Departemen
                </a>
                <a href="{{ route('master.users.index') }}" class="sidebar-link {{ request()->routeIs('master.users.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Users
                </a>
                <a href="{{ route('master.kategori-risiko.index') }}" class="sidebar-link {{ request()->routeIs('master.kategori-risiko.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori Risiko
                </a>
                <a href="{{ route('master.kriteria.index') }}" class="sidebar-link {{ request()->routeIs('master.kriteria.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Kriteria
                </a>
            </div>

        </div>

        <div class="px-3 py-4 border-t border-slate-100">
            <div class="sidebar-link text-slate-400 text-xs">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                v1.0.0
            </div>
        </div>

    </aside>

    {{-- MAIN --}}
    <main class="ml-[240px] flex-1 min-h-screen">

        {{-- TOP BAR --}}
        <header class="h-[56px] bg-white border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-30">
            <div>
                <h1 class="font-bold text-[15px] text-slate-900">Audit & Risk Intelligence</h1>
                <p class="text-[11px] text-slate-400 font-medium">Internal Audit Management System</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button onclick="document.getElementById('buDropdownTop').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 transition text-sm">
                        <div class="w-6 h-6 rounded-md bg-primary-50 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <span class="text-[13px] font-semibold text-slate-700 max-w-[120px] truncate">{{ session('active_business_unit_name', 'Pilih BU') }}</span>
                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="buDropdownTop" class="hidden absolute right-0 top-full mt-1 w-56 bg-white border border-slate-200 rounded-xl shadow-lg z-50 py-1">
                        @php
                            try { $allBu = \App\Models\BusinessUnit::where('is_active', true)->orderBy('nama')->get(); }
                            catch(\Exception $e) { $allBu = collect(); }
                        @endphp
                        @forelse($allBu as $bu)
                        <form action="{{ route('bu.select') }}" method="POST" class="block">
                            @csrf
                            <input type="hidden" name="business_unit_id" value="{{ $bu->id }}">
                            <button class="w-full text-left px-3 py-2 text-[13px] text-slate-600 hover:bg-slate-50 transition flex items-center gap-2.5 {{ session('active_business_unit_id') == $bu->id ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ session('active_business_unit_id') == $bu->id ? 'bg-primary-500' : 'bg-slate-300' }}"></span>
                                {{ $bu->kode }} · {{ $bu->nama }}
                            </button>
                        </form>
                        @empty
                        <div class="px-3 py-2 text-xs text-slate-400">Belum ada business unit</div>
                        @endforelse
                        <a href="{{ route('master.business-unit.index') }}" class="block px-3 py-2 text-xs text-primary-600 hover:text-primary-700 font-medium border-t border-slate-100 mt-1">+ Kelola Business Unit</a>
                    </div>
                </div>
                <button class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">WA</div>
                    <div class="hidden sm:block">
                        <div class="text-sm font-semibold text-slate-900">Wawan Andang</div>
                        <div class="text-[11px] text-slate-400 font-medium">Audit Manager</div>
                    </div>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <div class="p-8">
            @if(session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<div id="deleteModal" class="modal-overlay" onclick="if(event.target===this)closeDeleteModal()">
    <div class="modal-box p-6 max-w-md">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
                <p class="text-sm text-slate-500 mt-1" id="deleteMessage">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <button onclick="closeDeleteModal()" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="closeDeleteModal()" class="btn-secondary">Batal</button>
            <button type="button" onclick="confirmDeleteSubmit()" class="bg-red-500 text-white font-medium text-sm px-5 py-2.5 rounded-lg hover:bg-red-600 transition flex items-center gap-2" style="box-shadow: 0 1px 3px rgba(239,68,68,0.25);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

@stack('scripts')
<script>
let pendingDeleteUrl = null;
let pendingDeleteToken = null;
function showDeleteConfirm(btn, message) {
    pendingDeleteUrl = btn.getAttribute('data-action');
    pendingDeleteToken = btn.getAttribute('data-token');
    if (message) document.getElementById('deleteMessage').textContent = message;
    document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
    pendingDeleteUrl = null;
    pendingDeleteToken = null;
}
function confirmDeleteSubmit() {
    if (pendingDeleteUrl) {
        var url = pendingDeleteUrl;
        var token = pendingDeleteToken;
        closeDeleteModal();
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.innerHTML = '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDeleteModal(); }
});
</script>
</body>
</html>