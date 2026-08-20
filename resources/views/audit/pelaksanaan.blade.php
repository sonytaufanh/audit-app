@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8"><div><h2 class="text-[22px] font-bold text-slate-900">Pelaksanaan Audit</h2><p class="text-sm text-slate-500 mt-0.5">Monitoring pelaksanaan audit lapangan</p></div><button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button></div>
<div class="grid grid-cols-4 gap-4 mb-5">
    @php $sts = ['not_started'=>'Belum Mulai','in_progress'=>'Sedang Berjalan','completed'=>'Selesai','cancelled'=>'Dibatalkan']; $cls = ['bg-slate-50','bg-blue-50','bg-emerald-50','bg-red-50']; $tcl = ['text-slate-600','text-blue-600','text-emerald-600','text-red-600'] @endphp
    @foreach($sts as $k => $v)
    <div class="card p-5"><div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $v }}</div><div class="text-[28px] font-extrabold text-slate-900 mt-1">{{ $pelaksanaanAudits->where('status', $k)->count() }}</div></div>
    @endforeach
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Audit Universe</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Auditor</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($pelaksanaanAudits as $p)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $p->kode }}</td><td class="px-6 py-3.5">{{ $p->auditUniverse->nama ?? '-' }}</td><td class="px-6 py-3.5">{{ $p->auditor->name ?? '-' }}</td>
                <td class="px-6 py-3.5 text-xs">{{ $p->tanggal_mulai->format('d/m/Y') }} - {{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $p->status == 'not_started' ? 'badge-slate' : ($p->status == 'in_progress' ? 'badge-blue' : ($p->status == 'completed' ? 'badge-green' : 'badge-red')) }}">{{ str_replace('_', ' ', ucfirst($p->status)) }}</span></td>
                <td class="px-6 py-3.5 text-center"><button onclick="editData({{ $p->id }}, '{{ $p->kode }}', {{ $p->audit_plan_id ?? 'null' }}, {{ $p->audit_universe_id }}, {{ $p->auditor_id ?? 'null' }}, '{{ $p->tanggal_mulai->format('Y-m-d') }}', '{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('Y-m-d') : '' }}', '{{ $p->status }}', {{ $p->realisasi_anggaran }}, {!! json_encode($p->temuan_sementara) !!})" class="text-primary-600 font-medium text-xs mr-4">Edit</button><button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('audit.pelaksanaan.destroy', $p->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs">Hapus</button></td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data pelaksanaan audit</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Pelaksanaan Audit</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('audit.pelaksanaan.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Audit Universe</label><select name="audit_universe_id" id="audit_universe_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($auditUniverses as $a)<option value="{{ $a->id }}">{{ $a->kode }} - {{ $a->nama }}</option>@endforeach</select></div></div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Audit Plan</label><select name="audit_plan_id" id="audit_plan_id" class="input-field"><option value="">-- Pilih --</option>@foreach($auditPlans as $a)<option value="{{ $a->id }}">{{ $a->kode }}</option>@endforeach</select></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Auditor</label><select name="auditor_id" id="auditor_id" class="input-field"><option value="">-- Pilih --</option>@foreach($auditors as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div></div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Mulai</label><input type="date" name="tanggal_mulai" id="tanggal_mulai" required class="input-field"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Selesai</label><input type="date" name="tanggal_selesai" id="tanggal_selesai" class="input-field"></div></div>
    <div id="editFields" class="hidden space-y-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Status</label><select name="status" id="status" class="input-field"><option value="not_started">Belum Mulai</option><option value="in_progress">Sedang Berjalan</option><option value="completed">Selesai</option><option value="cancelled">Dibatalkan</option></select></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Temuan Sementara</label><textarea name="temuan_sementara" id="temuan_sementara" rows="2" class="input-field"></textarea></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Realisasi Anggaran</label><input type="number" name="realisasi_anggaran" id="realisasi_anggaran" step="0.01" min="0" class="input-field"></div></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; } function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, planId, universeId, auditorId, tglMulai, tglSelesai, status, realisasi, temuan) {
    document.getElementById('modalTitle').innerText = 'Edit Pelaksanaan Audit';
    document.getElementById('formData').action = '/audit/pelaksanaan/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode; document.getElementById('audit_plan_id').value = planId === 'null' ? '' : planId;
    document.getElementById('audit_universe_id').value = universeId; document.getElementById('auditor_id').value = auditorId === 'null' ? '' : auditorId;
    document.getElementById('tanggal_mulai').value = tglMulai; document.getElementById('tanggal_selesai').value = tglSelesai;
    document.getElementById('status').value = status; document.getElementById('realisasi_anggaran').value = realisasi;
    document.getElementById('temuan_sementara').value = temuan || ''; document.getElementById('editFields').classList.remove('hidden');
    openModal('modalForm');
}
</script>
@endpush