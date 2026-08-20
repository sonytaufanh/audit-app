@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Risk Register</h2><p class="text-sm text-slate-500 mt-0.5">Registrasi dan pemantauan risiko organisasi</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Risiko</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dept</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kategori</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">I</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">P</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Score</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Level</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @php
            function riskLevel($imp, $prob) {
                $score = $imp * $prob;
                if ($score >= 15) return ['level'=>'Critical','class'=>'badge-red'];
                if ($score >= 10) return ['level'=>'High','class'=>'badge-orange'];
                if ($score >= 5) return ['level'=>'Medium','class'=>'badge-yellow'];
                return ['level'=>'Low','class'=>'badge-green'];
            }
            @endphp
            @forelse($riskRegisters as $r)
            @php $rl = riskLevel($r->impact_score, $r->probability_score); @endphp
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $r->kode }}</td>
                <td class="px-6 py-3.5 max-w-[180px] truncate">{{ $r->nama }}</td>
                <td class="px-6 py-3.5">{{ $r->departemen->nama ?? '-' }}</td>
                <td class="px-6 py-3.5">{{ $r->kategoriRisiko->nama ?? '-' }}</td>
                <td class="px-6 py-3.5 text-center font-semibold">{{ $r->impact_score }}</td>
                <td class="px-6 py-3.5 text-center font-semibold">{{ $r->probability_score }}</td>
                <td class="px-6 py-3.5 text-center font-bold">{{ $r->impact_score * $r->probability_score }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $rl['class'] }}">{{ $rl['level'] }}</span></td>
                <td class="px-6 py-3.5"><span class="badge {{ $r->status == 'identified' ? 'badge-slate' : ($r->status == 'assessed' ? 'badge-blue' : ($r->status == 'treated' ? 'badge-yellow' : ($r->status == 'monitored' ? 'badge-purple' : 'badge-green'))) }}">{{ ucfirst($r->status) }}</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $r->id }}, '{{ $r->kode }}', '{{ addslashes($r->nama) }}', '{{ addslashes($r->deskripsi) }}', {{ $r->departemen_id }}, {{ $r->kategori_risiko_id }}, {{ $r->impact_score }}, {{ $r->probability_score }}, '{{ addslashes($r->penyebab) }}', '{{ addslashes($r->dampak) }}', '{{ addslashes($r->mitigasi) }}', {{ $r->risk_owner_id ?? 'null' }}, '{{ $r->tanggal_identifikasi ? $r->tanggal_identifikasi->format('Y-m-d') : '' }}', '{{ $r->status }}', '{{ $r->tanggal_review ? $r->tanggal_review->format('Y-m-d') : '' }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('risk.register.destroy', $r->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data risk register</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6 max-h-[90vh] overflow-y-auto"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Risk Register</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('risk.register.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama Risiko</label><input type="text" name="nama" id="nama" required maxlength="255" class="input-field"></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="2" class="input-field"></textarea></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Departemen</label><select name="departemen_id" id="departemen_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($departemens as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach</select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kategori Risiko</label><select name="kategori_risiko_id" id="kategori_risiko_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($kategoriRisikos as $k)<option value="{{ $k->id }}">{{ $k->nama }}</option>@endforeach</select></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Impact Score (1-5)</label><select name="impact_score" id="impact_score" required class="input-field"><option value="1">1 - Sangat Rendah</option><option value="2">2 - Rendah</option><option value="3">3 - Sedang</option><option value="4">4 - Tinggi</option><option value="5">5 - Sangat Tinggi</option></select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Probability Score (1-5)</label><select name="probability_score" id="probability_score" required class="input-field"><option value="1">1 - Sangat Rendah</option><option value="2">2 - Rendah</option><option value="3">3 - Sedang</option><option value="4">4 - Tinggi</option><option value="5">5 - Sangat Tinggi</option></select></div>
    </div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Penyebab</label><textarea name="penyebab" id="penyebab" rows="2" class="input-field"></textarea></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Dampak</label><textarea name="dampak" id="dampak" rows="2" class="input-field"></textarea></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Mitigasi</label><textarea name="mitigasi" id="mitigasi" rows="2" class="input-field"></textarea></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Risk Owner</label><select name="risk_owner_id" id="risk_owner_id" class="input-field"><option value="">-- Pilih --</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Identifikasi</label><input type="date" name="tanggal_identifikasi" id="tanggal_identifikasi" required value="{{ date('Y-m-d') }}" class="input-field"></div>
    </div>
    <div id="editFields" class="hidden space-y-4"><div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Status</label><select name="status" id="status" class="input-field"><option value="identified">Identified</option><option value="assessed">Assessed</option><option value="treated">Treated</option><option value="monitored">Monitored</option><option value="closed">Closed</option></select></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Review</label><input type="date" name="tanggal_review" id="tanggal_review" class="input-field"></div></div></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, nama, deskripsi, deptId, katId, impact, prob, penyebab, dampak, mitigasi, ownerId, tglIdentifikasi, status, tglReview) {
    document.getElementById('modalTitle').innerText = 'Edit Risk Register';
    document.getElementById('formData').action = '/risk/register/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode;
    document.getElementById('nama').value = nama;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('departemen_id').value = deptId;
    document.getElementById('kategori_risiko_id').value = katId;
    document.getElementById('impact_score').value = impact;
    document.getElementById('probability_score').value = prob;
    document.getElementById('penyebab').value = penyebab || '';
    document.getElementById('dampak').value = dampak || '';
    document.getElementById('mitigasi').value = mitigasi || '';
    document.getElementById('risk_owner_id').value = ownerId === 'null' ? '' : ownerId;
    document.getElementById('tanggal_identifikasi').value = tglIdentifikasi;
    document.getElementById('status').value = status;
    document.getElementById('tanggal_review').value = tglReview;
    document.getElementById('editFields').classList.remove('hidden');
    openModal('modalForm');
}
</script>
@endpush