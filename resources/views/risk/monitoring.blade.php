@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Risk Monitoring</h2><p class="text-sm text-slate-500 mt-0.5">Pemantauan berkala perubahan level risiko</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Risk</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Impact</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Prob</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Score</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Level</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Reported By</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @php
            function mRiskLevel($imp, $prob) {
                $score = $imp * $prob;
                if ($score >= 15) return ['level'=>'Critical','class'=>'badge-red'];
                if ($score >= 10) return ['level'=>'High','class'=>'badge-orange'];
                if ($score >= 5) return ['level'=>'Medium','class'=>'badge-yellow'];
                return ['level'=>'Low','class'=>'badge-green'];
            }
            @endphp
            @forelse($monitorings as $m)
            @php $rl = mRiskLevel($m->impact_score, $m->probability_score); @endphp
            <tr class="table-row">
                <td class="px-6 py-3.5 text-xs">{{ $m->tanggal->format('d/m/Y') }}</td>
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $m->riskRegister->kode ?? '-' }} - {{ $m->riskRegister->nama ?? '-' }}</td>
                <td class="px-6 py-3.5 text-center font-semibold">{{ $m->impact_score }}</td>
                <td class="px-6 py-3.5 text-center font-semibold">{{ $m->probability_score }}</td>
                <td class="px-6 py-3.5 text-center font-bold">{{ $m->impact_score * $m->probability_score }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $rl['class'] }}">{{ $rl['level'] }}</span></td>
                <td class="px-6 py-3.5 text-xs">{{ $m->reportedBy->name ?? '-' }}</td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $m->id }}, {{ $m->risk_register_id }}, '{{ $m->tanggal->format('Y-m-d') }}', {{ $m->impact_score }}, {{ $m->probability_score }}, '{{ addslashes($m->catatan) }}', '{{ addslashes($m->tindakan) }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('risk.monitoring.destroy', $m->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data monitoring risiko</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Risk Monitoring</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('risk.monitoring.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Risk Register</label><select name="risk_register_id" id="risk_register_id" required class="input-field"><option value="">-- Pilih --</option>@foreach($riskRegisters as $r)<option value="{{ $r->id }}">{{ $r->kode }} - {{ $r->nama }}</option>@endforeach</select></div>
    <div class="grid grid-cols-3 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tanggal</label><input type="date" name="tanggal" id="tanggal" required value="{{ date('Y-m-d') }}" class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Impact (1-5)</label><select name="impact_score" id="impact_score" required class="input-field"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Prob (1-5)</label><select name="probability_score" id="probability_score" required class="input-field"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>
    </div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Catatan</label><textarea name="catatan" id="catatan" rows="2" class="input-field"></textarea></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tindakan</label><textarea name="tindakan" id="tindakan" rows="2" class="input-field"></textarea></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, riskId, tanggal, impact, prob, catatan, tindakan) {
    document.getElementById('modalTitle').innerText = 'Edit Risk Monitoring';
    document.getElementById('formData').action = '/risk/monitoring/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('risk_register_id').value = riskId;
    document.getElementById('tanggal').value = tanggal;
    document.getElementById('impact_score').value = impact;
    document.getElementById('probability_score').value = prob;
    document.getElementById('catatan').value = catatan || '';
    document.getElementById('tindakan').value = tindakan || '';
    openModal('modalForm');
}
</script>
@endpush