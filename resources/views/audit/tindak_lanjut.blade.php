@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Tindak Lanjut</h2><p class="text-sm text-slate-500 mt-0.5">Monitoring rencana tindak lanjut temuan audit</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Temuan</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Deskripsi</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">PJ</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rencana</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Selesai</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($tindakLanjuts as $tl)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $tl->temuanAudit->kode ?? '-' }}</td>
                <td class="px-6 py-3.5 max-w-[200px] truncate">{{ $tl->deskripsi }}</td>
                <td class="px-6 py-3.5">{{ $tl->penanggungJawab->name ?? '-' }}</td>
                <td class="px-6 py-3.5 text-xs">{{ $tl->tanggal_rencana ? $tl->tanggal_rencana->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-3.5 text-xs">{{ $tl->tanggal_selesai ? $tl->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $tl->status == 'open' ? 'badge-yellow' : ($tl->status == 'in_progress' ? 'badge-blue' : ($tl->status == 'completed' ? 'badge-green' : ($tl->status == 'verified' ? 'badge-purple' : 'badge-red'))) }}">{{ str_replace('_', ' ', ucfirst($tl->status)) }}</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $tl->id }}, {{ $tl->temuan_audit_id }}, '{{ addslashes($tl->deskripsi) }}', '{{ $tl->tanggal_rencana ? $tl->tanggal_rencana->format('Y-m-d') : '' }}', {{ $tl->penanggung_jawab_id ?? 'null' }}, '{{ $tl->status }}', '{{ $tl->tanggal_selesai ? $tl->tanggal_selesai->format('Y-m-d') : '' }}', '{{ addslashes($tl->bukti) }}', '{{ addslashes($tl->catatan_verifikasi) }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('audit.tindak-lanjut.destroy', $tl->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data tindak lanjut</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Tindak Lanjut</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('audit.tindak-lanjut.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Temuan Audit</label><select name="temuan_audit_id" id="temuan_audit_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($temuanAudits as $t)<option value="{{ $t->id }}">{{ $t->kode }} - {{ $t->judul }}</option>@endforeach</select></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" required rows="3" class="input-field"></textarea></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Penanggung Jawab</label><select name="penanggung_jawab_id" id="penanggung_jawab_id" class="input-field"><option value="">-- Pilih --</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Rencana</label><input type="date" name="tanggal_rencana" id="tanggal_rencana" required class="input-field"></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Selesai</label><input type="date" name="tanggal_selesai" id="tanggal_selesai" class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Status</label><select name="status" id="status" required class="input-field"><option value="open">Open</option><option value="in_progress">In Progress</option><option value="completed">Completed</option><option value="overdue">Overdue</option><option value="verified">Verified</option></select></div>
    </div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Bukti</label><textarea name="bukti" id="bukti" rows="2" class="input-field"></textarea></div>
    <div id="verifiedField" class="hidden"><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Catatan Verifikasi</label><textarea name="catatan_verifikasi" id="catatan_verifikasi" rows="2" class="input-field"></textarea></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, temuanId, deskripsi, tglRencana, pjId, status, tglSelesai, bukti, catatanVerifikasi) {
    document.getElementById('modalTitle').innerText = 'Edit Tindak Lanjut';
    document.getElementById('formData').action = '/audit/tindak-lanjut/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('temuan_audit_id').value = temuanId;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('tanggal_rencana').value = tglRencana;
    document.getElementById('penanggung_jawab_id').value = pjId === 'null' ? '' : pjId;
    document.getElementById('status').value = status;
    document.getElementById('tanggal_selesai').value = tglSelesai;
    document.getElementById('bukti').value = bukti || '';
    document.getElementById('catatan_verifikasi').value = catatanVerifikasi || '';
    document.getElementById('verifiedField').classList.remove('hidden');
    openModal('modalForm');
}
</script>
@endpush