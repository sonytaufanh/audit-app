@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Temuan Audit</h2><p class="text-sm text-slate-500 mt-0.5">Pencatatan temuan hasil audit lapangan</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Judul</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dept</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Severity</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tipe</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Target</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($temuanAudits as $t)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $t->kode }}</td>
                <td class="px-6 py-3.5 max-w-[200px] truncate">{{ $t->judul }}</td>
                <td class="px-6 py-3.5">{{ $t->departemen->nama ?? '-' }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $t->severity == 'critical' ? 'badge-red' : ($t->severity == 'high' ? 'badge-orange' : ($t->severity == 'medium' ? 'badge-yellow' : 'badge-green')) }}">{{ ucfirst($t->severity) }}</span></td>
                <td class="px-6 py-3.5"><span class="badge badge-purple">{{ str_replace('_', ' ', $t->tipe) }}</span></td>
                <td class="px-6 py-3.5"><span class="badge {{ $t->status == 'open' ? 'badge-yellow' : ($t->status == 'in_progress' ? 'badge-blue' : ($t->status == 'closed' ? 'badge-green' : 'badge-red')) }}">{{ str_replace('_', ' ', ucfirst($t->status)) }}</span></td>
                <td class="px-6 py-3.5 text-xs">{{ $t->target_closure ? $t->target_closure->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $t->id }}, '{{ $t->kode }}', {{ $t->pelaksanaan_audit_id }}, {{ $t->departemen_id }}, '{{ addslashes($t->judul) }}', '{{ addslashes($t->deskripsi) }}', '{{ $t->severity }}', '{{ $t->tipe }}', '{{ addslashes($t->rekomendasi) }}', '{{ $t->tanggal_temuan->format('Y-m-d') }}', '{{ $t->target_closure ? $t->target_closure->format('Y-m-d') : '' }}', '{{ addslashes($t->root_cause_category) }}', '{{ addslashes($t->root_cause) }}', {{ $t->assigned_to ?? 'null' }}, '{{ $t->status }}', '{{ $t->actual_closure ? $t->actual_closure->format('Y-m-d') : '' }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('audit.temuan.destroy', $t->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data temuan audit</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6 max-h-[90vh] overflow-y-auto"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Temuan Audit</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('audit.temuan.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Pelaksanaan Audit</label><select name="pelaksanaan_audit_id" id="pelaksanaan_audit_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($pelaksanaanAudits as $p)<option value="{{ $p->id }}">{{ $p->kode }} - {{ $p->auditUniverse->nama ?? '-' }}</option>@endforeach</select></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Judul</label><input type="text" name="judul" id="judul" required maxlength="255" class="input-field"></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="3" class="input-field"></textarea></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Departemen</label><select name="departemen_id" id="departemen_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($departemens as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach</select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Severity</label><select name="severity" id="severity" required class="input-field"><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="critical">Critical</option></select></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tipe</label><select name="tipe" id="tipe" required class="input-field"><option value="observasi">Observasi</option><option value="ketidaksesuaian">Ketidaksesuaian</option><option value="peluang_perbaikan">Peluang Perbaikan</option><option value="pelanggaran">Pelanggaran</option></select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Assigned To</label><select name="assigned_to" id="assigned_to" class="input-field"><option value="">-- Pilih --</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
    </div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Temuan</label><input type="date" name="tanggal_temuan" id="tanggal_temuan" required class="input-field"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Target Closure</label><input type="date" name="target_closure" id="target_closure" class="input-field"></div></div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Root Cause Category</label><input type="text" name="root_cause_category" id="root_cause_category" maxlength="100" class="input-field"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Root Cause</label><textarea name="root_cause" id="root_cause" rows="2" class="input-field"></textarea></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Rekomendasi</label><textarea name="rekomendasi" id="rekomendasi" rows="2" class="input-field"></textarea></div>
    <div id="editFields" class="hidden space-y-4"><div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Status</label><select name="status" id="status" class="input-field"><option value="open">Open</option><option value="in_progress">In Progress</option><option value="closed">Closed</option><option value="overdue">Overdue</option></select></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Actual Closure</label><input type="date" name="actual_closure" id="actual_closure" class="input-field"></div></div></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, pelaksanaanId, deptId, judul, deskripsi, severity, tipe, rekomendasi, tglTemuan, targetClosure, rootCauseCat, rootCause, assignedTo, status, actualClosure) {
    document.getElementById('modalTitle').innerText = 'Edit Temuan Audit';
    document.getElementById('formData').action = '/audit/temuan/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode;
    document.getElementById('pelaksanaan_audit_id').value = pelaksanaanId;
    document.getElementById('departemen_id').value = deptId;
    document.getElementById('judul').value = judul;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('severity').value = severity;
    document.getElementById('tipe').value = tipe;
    document.getElementById('rekomendasi').value = rekomendasi || '';
    document.getElementById('tanggal_temuan').value = tglTemuan;
    document.getElementById('target_closure').value = targetClosure;
    document.getElementById('root_cause_category').value = rootCauseCat || '';
    document.getElementById('root_cause').value = rootCause || '';
    document.getElementById('assigned_to').value = assignedTo === 'null' ? '' : assignedTo;
    document.getElementById('status').value = status;
    document.getElementById('actual_closure').value = actualClosure;
    document.getElementById('editFields').classList.remove('hidden');
    openModal('modalForm');
}
</script>
@endpush