@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Kriteria Penilaian</h2><p class="text-sm text-slate-500 mt-0.5">Kriteria penilaian impact, probability, dan likelihood risiko</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tipe</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nilai</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Label</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($kriteriaPenilaians as $k)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $k->kode }}</td>
                <td class="px-6 py-3.5">{{ $k->nama }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $k->tipe == 'impact' ? 'badge-orange' : ($k->tipe == 'probability' ? 'badge-blue' : 'badge-purple') }}">{{ ucfirst(str_replace('_', ' ', $k->tipe)) }}</span></td>
                <td class="px-6 py-3.5 text-center font-bold">{{ $k->nilai }}</td>
                <td class="px-6 py-3.5"><span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full inline-block" style="background: {{ $k->warna }}"></span>{{ $k->label }}</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $k->id }}, '{{ $k->kode }}', '{{ addslashes($k->nama) }}', '{{ $k->tipe }}', {{ $k->nilai }}, '{{ addslashes($k->label) }}', '{{ addslashes($k->deskripsi) }}', '{{ $k->warna }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('master.kriteria.destroy', $k->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data kriteria penilaian</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Kriteria Penilaian</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('master.kriteria.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="nama" id="nama" required maxlength="100" class="input-field"></div></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tipe</label><select name="tipe" id="tipe" required class="input-field"><option value="impact">Impact</option><option value="probability">Probability</option><option value="likelihood">Likelihood</option></select></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nilai (1-5)</label><select name="nilai" id="nilai" required class="input-field"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>
    </div>
    <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Label</label><input type="text" name="label" id="label" required maxlength="50" class="input-field"></div><div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Warna</label><input type="color" name="warna" id="warna" class="input-field h-[42px] px-2"></div></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="2" class="input-field"></textarea></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, nama, tipe, nilai, label, deskripsi, warna) {
    document.getElementById('modalTitle').innerText = 'Edit Kriteria Penilaian';
    document.getElementById('formData').action = '/master/kriteria/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode;
    document.getElementById('nama').value = nama;
    document.getElementById('tipe').value = tipe;
    document.getElementById('nilai').value = nilai;
    document.getElementById('label').value = label;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('warna').value = warna || '#6366f1';
    openModal('modalForm');
}
</script>
@endpush