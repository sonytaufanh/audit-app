@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Kategori Risiko</h2><p class="text-sm text-slate-500 mt-0.5">Kelola kategori risiko untuk risk register</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah</button>
</div>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Deskripsi</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($kategoriRisikos as $k)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $k->kode }}</td>
                <td class="px-6 py-3.5">{{ $k->nama }}</td>
                <td class="px-6 py-3.5 text-slate-400 text-xs max-w-[250px] truncate">{{ $k->deskripsi ?? '-' }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ ($k->is_active ?? true) ? 'badge-green' : 'badge-red' }}">{{ ($k->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $k->id }}, '{{ $k->kode }}', '{{ addslashes($k->nama) }}', '{{ addslashes($k->deskripsi) }}')" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('master.kategori-risiko.destroy', $k->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data kategori risiko</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="modalForm" class="modal-overlay"><div class="modal-box p-6"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Kategori Risiko</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('master.kategori-risiko.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><div id="kodeInfo" class="input-field bg-slate-50 border-slate-200 text-slate-400 text-xs flex items-center">Kode dibuat otomatis</div><input type="text" name="kode" id="kode" readonly class="input-field bg-slate-50 text-slate-500 cursor-not-allowed" style="display:none"></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="nama" id="nama" required maxlength="100" class="input-field"></div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="2" class="input-field"></textarea></div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection
@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); document.getElementById('kodeInfo').style.display=''; document.getElementById('kode').style.display='none'; }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, nama, deskripsi) {
    document.getElementById('modalTitle').innerText = 'Edit Kategori Risiko';
    document.getElementById('formData').action = '/master/kategori-risiko/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kodeInfo').style.display='none'; document.getElementById('kode').style.display=''; document.getElementById('kode').value = kode;
    document.getElementById('nama').value = nama;
    document.getElementById('deskripsi').value = deskripsi || '';
    openModal('modalForm');
}
</script>
@endpush