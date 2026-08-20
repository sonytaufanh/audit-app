@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Audit Plan</h2><p class="text-sm text-slate-500 mt-0.5">Rencana dan jadwal audit tahunan</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tahun</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Periode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Anggaran</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($auditPlans as $a)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $a->kode }}</td><td class="px-6 py-3.5">{{ $a->nama }}</td><td class="px-6 py-3.5">{{ $a->tahun }}</td><td class="px-6 py-3.5">{{ $a->periode }}</td>
                <td class="px-6 py-3.5 text-xs">{{ $a->tanggal_mulai->format('d/m/Y') }} - {{ $a->tanggal_selesai->format('d/m/Y') }}</td>
                <td class="px-6 py-3.5">Rp {{ number_format($a->anggaran, 0, ',', '.') }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $a->status == 'disetujui' ? 'badge-green' : ($a->status == 'draft' ? 'badge-yellow' : ($a->status == 'selesai' ? 'badge-blue' : 'badge-red')) }}">{{ ucfirst($a->status) }}</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $a->id }}, '{{ $a->kode }}', '{{ $a->nama }}', {{ $a->tahun }}, '{{ $a->periode }}', '{{ $a->tanggal_mulai->format('Y-m-d') }}', '{{ $a->tanggal_selesai->format('Y-m-d') }}', {{ $a->anggaran }}, '{{ $a->status }}', '{{ $a->deskripsi }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('audit.plan.destroy', $a->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data audit plan</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6 max-h-[90vh] overflow-y-auto"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Audit Plan</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('audit.plan.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="nama" id="nama" required maxlength="200" class="input-field"></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="2" class="input-field"></textarea></div>
    <div class="grid grid-cols-3 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tahun</label><input type="number" name="tahun" id="tahun" required value="{{ date('Y') }}" class="input-field"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Periode</label><select name="periode" id="periode" required class="input-field"><option>Q1</option><option>Q2</option><option>Q3</option><option>Q4</option><option>Semester 1</option><option>Semester 2</option><option>Tahunan</option></select></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Anggaran</label><input type="number" name="anggaran" id="anggaran" step="0.01" min="0" class="input-field"></div></div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Mulai</label><input type="date" name="tanggal_mulai" id="tanggal_mulai" required class="input-field"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tgl Selesai</label><input type="date" name="tanggal_selesai" id="tanggal_selesai" required class="input-field"></div></div>
    <div id="statusGroup" class="hidden"><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Status</label><select name="status" id="status" class="input-field"><option value="draft">Draft</option><option value="disetujui">Disetujui</option><option value="ditolak">Ditolak</option><option value="selesai">Selesai</option></select></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, nama, tahun, periode, tglMulai, tglSelesai, anggaran, status, deskripsi) {
    document.getElementById('modalTitle').innerText = 'Edit Audit Plan';
    document.getElementById('formData').action = '/audit/plan/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode; document.getElementById('nama').value = nama;
    document.getElementById('tahun').value = tahun; document.getElementById('periode').value = periode;
    document.getElementById('tanggal_mulai').value = tglMulai; document.getElementById('tanggal_selesai').value = tglSelesai;
    document.getElementById('anggaran').value = anggaran; document.getElementById('status').value = status;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('statusGroup').classList.remove('hidden');
    openModal('modalForm');
}
</script>
@endpush