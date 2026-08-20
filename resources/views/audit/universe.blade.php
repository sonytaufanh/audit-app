@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Audit Universe</h2><p class="text-sm text-slate-500 mt-0.5">Daftar objek audit yang dapat diaudit</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dept</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tipe</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Risk</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Last Audit</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($auditUniverses as $a)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $a->kode }}</td><td class="px-6 py-3.5">{{ $a->nama }}</td><td class="px-6 py-3.5">{{ $a->departemen->nama ?? '-' }}</td>
                <td class="px-6 py-3.5"><span class="badge badge-purple">{{ str_replace('_', ' ', $a->tipe) }}</span></td>
                <td class="px-6 py-3.5"><span class="badge {{ $a->risk_level == 'critical' ? 'badge-red' : ($a->risk_level == 'high' ? 'badge-orange' : ($a->risk_level == 'medium' ? 'badge-yellow' : 'badge-green')) }}">{{ ucfirst($a->risk_level) }}</span></td>
                <td class="px-6 py-3.5 text-xs">{{ $a->last_audit_date ? $a->last_audit_date->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $a->id }}, '{{ $a->kode }}', '{{ $a->nama }}', {{ $a->departemen_id }}, '{{ $a->tipe }}', '{{ $a->risk_level }}', {{ $a->audit_frequency_months }}, '{{ $a->deskripsi }}')" class="text-primary-600 font-medium text-xs mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('audit.universe.destroy', $a->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data audit universe</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Audit Universe</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('audit.universe.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="nama" id="nama" required maxlength="200" class="input-field"></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="2" class="input-field"></textarea></div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Departemen</label><select name="departemen_id" id="departemen_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($departemens as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach</select></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tipe</label><select name="tipe" id="tipe" required class="input-field"><option value="operasional">Operasional</option><option value="keuangan">Keuangan</option><option value="kepatuhan">Kepatuhan</option><option value="teknologi_informasi">TI</option><option value="strategis">Strategis</option></select></div></div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Risk Level</label><select name="risk_level" id="risk_level" required class="input-field"><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="critical">Critical</option></select></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Frekuensi (bulan)</label><input type="number" name="audit_frequency_months" id="audit_frequency_months" min="1" value="12" class="input-field"></div></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, nama, deptId, tipe, riskLevel, freq, deskripsi) {
    document.getElementById('modalTitle').innerText = 'Edit Audit Universe';
    document.getElementById('formData').action = '/audit/universe/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode; document.getElementById('nama').value = nama;
    document.getElementById('departemen_id').value = deptId; document.getElementById('tipe').value = tipe;
    document.getElementById('risk_level').value = riskLevel; document.getElementById('audit_frequency_months').value = freq;
    document.getElementById('deskripsi').value = deskripsi || '';
    openModal('modalForm');
}
</script>
@endpush