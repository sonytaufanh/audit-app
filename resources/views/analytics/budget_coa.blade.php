@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Budget COA</h2><p class="text-sm text-slate-500 mt-0.5">Chart of Accounts dan manajemen anggaran</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
@php
$totalAnggaran = $budgetCoas->sum('anggaran');
$totalRealisasi = $budgetCoas->sum('realisasi');
$sisa = $totalAnggaran - $totalRealisasi;
$persen = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : 0;
@endphp
<div class="grid grid-cols-4 gap-4 mb-5">
    <div class="card p-5"><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Anggaran</div><div class="text-xl font-extrabold text-slate-900 mt-1">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</div></div>
    <div class="card p-5"><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Realisasi</div><div class="text-xl font-extrabold text-blue-600 mt-1">Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</div></div>
    <div class="card p-5"><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sisa</div><div class="text-xl font-extrabold {{ $sisa >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-1">Rp {{ number_format($sisa, 0, ',', '.') }}</div></div>
    <div class="card p-5"><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">% Realisasi</div><div class="text-xl font-extrabold {{ $persen <= 100 ? 'text-slate-900' : 'text-red-600' }} mt-1">{{ $persen }}%</div></div>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode COA</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tipe</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dept</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tahun</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Periode</th><th class="text-right px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Anggaran</th><th class="text-right px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Realisasi</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">%</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($budgetCoas as $b)
            @php $p = $b->anggaran > 0 ? round(($b->realisasi / $b->anggaran) * 100, 1) : 0; @endphp
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $b->kode_coa }}</td>
                <td class="px-6 py-3.5 max-w-[150px] truncate">{{ $b->nama }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $b->tipe == 'pendapatan' ? 'badge-green' : ($b->tipe == 'beban' ? 'badge-red' : ($b->tipe == 'aset' ? 'badge-blue' : ($b->tipe == 'kewajiban' ? 'badge-orange' : 'badge-purple'))) }}">{{ ucfirst($b->tipe) }}</span></td>
                <td class="px-6 py-3.5">{{ $b->departemen->nama ?? '-' }}</td>
                <td class="px-6 py-3.5">{{ $b->tahun }}</td>
                <td class="px-6 py-3.5">{{ $b->periode }}</td>
                <td class="px-6 py-3.5 text-right">Rp {{ number_format($b->anggaran, 0, ',', '.') }}</td>
                <td class="px-6 py-3.5 text-right">Rp {{ number_format($b->realisasi, 0, ',', '.') }}</td>
                <td class="px-6 py-3.5 text-center"><span class="badge {{ $p > 100 ? 'badge-red' : ($p >= 80 ? 'badge-yellow' : 'badge-green') }}">{{ $p }}%</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $b->id }}, '{{ $b->kode_coa }}', '{{ addslashes($b->nama) }}', '{{ $b->tipe }}', {{ $b->departemen_id ?? 'null' }}, {{ $b->anggaran }}, {{ $b->realisasi }}, {{ $b->tahun }}, '{{ $b->periode }}', '{{ addslashes($b->keterangan) }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('budget.budget-coa.destroy', $b->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data budget COA</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6 max-h-[90vh] overflow-y-auto"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Budget COA</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('budget.budget-coa.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode COA</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode_coa" id="kode_coa" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="nama" id="nama" required maxlength="255" class="input-field"></div></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tipe</label><select name="tipe" id="tipe" required class="input-field"><option value="pendapatan">Pendapatan</option><option value="beban">Beban</option><option value="aset">Aset</option><option value="kewajiban">Kewajiban</option><option value="ekuitas">Ekuitas</option></select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Departemen</label><select name="departemen_id" id="departemen_id" class="input-field"><option value="">-- Pilih --</option>@foreach($departemens as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach</select></div>
    </div>
    <div class="grid grid-cols-3 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tahun</label><input type="number" name="tahun" id="tahun" required value="{{ date('Y') }}" class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Periode</label><select name="periode" id="periode" required class="input-field"><option value="Q1">Q1</option><option value="Q2">Q2</option><option value="Q3">Q3</option><option value="Q4">Q4</option><option value="Tahunan">Tahunan</option></select></div>
        <div>&nbsp;</div>
    </div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Anggaran</label><input type="number" name="anggaran" id="anggaran" step="0.01" min="0" required class="input-field"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Realisasi</label><input type="number" name="realisasi" id="realisasi" step="0.01" min="0" value="0" class="input-field"></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Keterangan</label><textarea name="keterangan" id="keterangan" rows="2" class="input-field"></textarea></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode_coa').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kodeCoa, nama, tipe, deptId, anggaran, realisasi, tahun, periode, keterangan) {
    document.getElementById('modalTitle').innerText = 'Edit Budget COA';
    document.getElementById('formData').action = '/analytics/budget-coa/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode_coa').style.display=''; document.getElementById('kode_coa').value = kodeCoa;
    document.getElementById('nama').value = nama;
    document.getElementById('tipe').value = tipe;
    document.getElementById('departemen_id').value = deptId === 'null' ? '' : deptId;
    document.getElementById('anggaran').value = anggaran;
    document.getElementById('realisasi').value = realisasi;
    document.getElementById('tahun').value = tahun;
    document.getElementById('periode').value = periode;
    document.getElementById('keterangan').value = keterangan || '';
    openModal('modalForm');
}
</script>
@endpush