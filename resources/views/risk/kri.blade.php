@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Key Risk Indicator (KRI)</h2><p class="text-sm text-slate-500 mt-0.5">Pemantauan indikator risiko utama</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
@php
$green = $kris->filter(function($k) { return $k->current_value >= $k->threshold_min && $k->current_value <= $k->threshold_max; })->count();
$yellow = $kris->filter(function($k) { return $k->current_value < $k->threshold_min && $k->current_value >= ($k->threshold_min * 0.7); })->count();
$red = $kris->filter(function($k) { return $k->current_value < ($k->threshold_min * 0.7) || $k->current_value > $k->threshold_max; })->count();
@endphp
<div class="grid grid-cols-3 gap-4 mb-5">
    <div class="card p-5 flex items-center gap-4"><div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center"><svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><div><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Green</div><div class="text-2xl font-extrabold text-slate-900">{{ $green }}</div></div></div>
    <div class="card p-5 flex items-center gap-4"><div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center"><svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg></div><div><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Yellow</div><div class="text-2xl font-extrabold text-slate-900">{{ $yellow }}</div></div></div>
    <div class="card p-5 flex items-center gap-4"><div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center"><svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div><div><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Red</div><div class="text-2xl font-extrabold text-slate-900">{{ $red }}</div></div></div>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dept</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Current</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Target</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Threshold</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($kris as $k)
            @php
            $st = 'green';
            if ($k->current_value < $k->threshold_min && $k->current_value >= ($k->threshold_min * 0.7)) $st = 'yellow';
            elseif ($k->current_value < ($k->threshold_min * 0.7) || $k->current_value > $k->threshold_max) $st = 'red';
            @endphp
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $k->kode }}</td>
                <td class="px-6 py-3.5 max-w-[180px] truncate">{{ $k->nama }}</td>
                <td class="px-6 py-3.5">{{ $k->departemen->nama ?? '-' }}</td>
                <td class="px-6 py-3.5 font-semibold">{{ $k->current_value }} {{ $k->satuan }}</td>
                <td class="px-6 py-3.5">{{ $k->target }} {{ $k->satuan }}</td>
                <td class="px-6 py-3.5 text-xs">{{ $k->threshold_min }} - {{ $k->threshold_max }} {{ $k->satuan }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $st == 'green' ? 'badge-green' : ($st == 'yellow' ? 'badge-yellow' : 'badge-red') }}">{{ ucfirst($st) }}</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $k->id }}, '{{ $k->kode }}', '{{ addslashes($k->nama) }}', '{{ addslashes($k->deskripsi) }}', {{ $k->risk_register_id ?? 'null' }}, {{ $k->departemen_id }}, '{{ $k->target }}', '{{ $k->current_value }}', '{{ $k->threshold_min }}', '{{ $k->threshold_max }}', '{{ $k->satuan }}', '{{ $k->frekuensi }}', '{{ $k->last_update ? $k->last_update->format('Y-m-d') : '' }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('risk.kri.destroy', $k->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data KRI</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6 max-h-[90vh] overflow-y-auto"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah KRI</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('risk.kri.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="nama" id="nama" required maxlength="255" class="input-field"></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="2" class="input-field"></textarea></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Risk Register</label><select name="risk_register_id" id="risk_register_id" class="input-field"><option value="">-- Pilih --</option>@foreach($riskRegisters as $r)<option value="{{ $r->id }}">{{ $r->kode }} - {{ $r->nama }}</option>@endforeach</select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Departemen</label><select name="departemen_id" id="departemen_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($departemens as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach</select></div>
    </div>
    <div class="grid grid-cols-3 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Target</label><input type="number" name="target" id="target" step="0.01" required class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Current Value</label><input type="number" name="current_value" id="current_value" step="0.01" required class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Satuan</label><input type="text" name="satuan" id="satuan" maxlength="20" placeholder="%" class="input-field"></div>
    </div>
    <div class="grid grid-cols-3 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Threshold Min</label><input type="number" name="threshold_min" id="threshold_min" step="0.01" required class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Threshold Max</label><input type="number" name="threshold_max" id="threshold_max" step="0.01" required class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Frekuensi</label><select name="frekuensi" id="frekuensi" required class="input-field"><option value="harian">Harian</option><option value="mingguan">Mingguan</option><option value="bulanan">Bulanan</option><option value="triwulan">Triwulan</option><option value="semesteran">Semesteran</option><option value="tahunan">Tahunan</option></select></div>
    </div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Last Update</label><input type="date" name="last_update" id="last_update" class="input-field" value="{{ date('Y-m-d') }}"></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, nama, deskripsi, riskId, deptId, target, current, thMin, thMax, satuan, frekuensi, lastUpdate) {
    document.getElementById('modalTitle').innerText = 'Edit KRI';
    document.getElementById('formData').action = '/risk/kri/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode;
    document.getElementById('nama').value = nama;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('risk_register_id').value = riskId === 'null' ? '' : riskId;
    document.getElementById('departemen_id').value = deptId;
    document.getElementById('target').value = target;
    document.getElementById('current_value').value = current;
    document.getElementById('threshold_min').value = thMin;
    document.getElementById('threshold_max').value = thMax;
    document.getElementById('satuan').value = satuan || '';
    document.getElementById('frekuensi').value = frekuensi;
    document.getElementById('last_update').value = lastUpdate;
    openModal('modalForm');
}
</script>
@endpush