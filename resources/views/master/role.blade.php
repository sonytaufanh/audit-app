@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Role</h2><p class="text-sm text-slate-500 mt-0.5">Kelola role dan hak akses pengguna</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah Role</button>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100">
            <th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kode</th>
            <th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th>
            <th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Create</th>
            <th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Read</th>
            <th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Update</th>
            <th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Delete</th>
            <th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Approve</th>
            <th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
        </tr></thead>
        <tbody>
            @forelse($roles as $r)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $r->kode }}</td>
                <td class="px-6 py-3.5">{{ $r->nama }}</td>
                @php $perms = ['can_create','can_read','can_update','can_delete','can_approve']; @endphp
                @foreach($perms as $perm)
                <td class="px-6 py-3.5 text-center">
                    @if($r->$perm)
                    <svg class="w-4 h-4 text-emerald-500 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                    <svg class="w-4 h-4 text-slate-300 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    @endif
                </td>
                @endforeach
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $r->id }}, '{{ $r->kode }}', '{{ addslashes($r->nama) }}', '{{ addslashes($r->deskripsi) }}', {{ $r->can_create ? 'true' : 'false' }}, {{ $r->can_read ? 'true' : 'false' }}, {{ $r->can_update ? 'true' : 'false' }}, {{ $r->can_delete ? 'true' : 'false' }}, {{ $r->can_approve ? 'true' : 'false' }})" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('master.role.destroy', $r->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data role</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="modalForm" class="modal-overlay"><div class="modal-box p-6 max-h-[90vh] overflow-y-auto"><div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Role</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form id="formData" method="POST" action="{{ route('master.role.store') }}">@csrf<div id="methodField"></div>
<div class="space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kode</label><input type="text" name="kode" id="kode" required maxlength="3" style="text-transform:uppercase" class="input-field"></div>
        <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="nama" id="nama" required maxlength="100" class="input-field"></div>
    </div>
    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="2" class="input-field"></textarea></div>
    <div>
        <label class="text-xs font-semibold text-slate-500 mb-2 block">Hak Akses</label>
        <div class="grid grid-cols-5 gap-3">
            <label class="flex items-center gap-2 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                <input type="checkbox" name="can_create" id="can_create" class="w-4 h-4 rounded text-primary-600 border-slate-300 focus:ring-primary-500">
                <span class="text-xs font-medium text-slate-600">Create</span>
            </label>
            <label class="flex items-center gap-2 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                <input type="checkbox" name="can_read" id="can_read" class="w-4 h-4 rounded text-primary-600 border-slate-300 focus:ring-primary-500">
                <span class="text-xs font-medium text-slate-600">Read</span>
            </label>
            <label class="flex items-center gap-2 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                <input type="checkbox" name="can_update" id="can_update" class="w-4 h-4 rounded text-primary-600 border-slate-300 focus:ring-primary-500">
                <span class="text-xs font-medium text-slate-600">Update</span>
            </label>
            <label class="flex items-center gap-2 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                <input type="checkbox" name="can_delete" id="can_delete" class="w-4 h-4 rounded text-primary-600 border-slate-300 focus:ring-primary-500">
                <span class="text-xs font-medium text-slate-600">Delete</span>
            </label>
            <label class="flex items-center gap-2 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                <input type="checkbox" name="can_approve" id="can_approve" class="w-4 h-4 rounded text-primary-600 border-slate-300 focus:ring-primary-500">
                <span class="text-xs font-medium text-slate-600">Approve</span>
            </label>
        </div>
    </div>
</div>
<div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.getElementById('formData').reset();
    document.getElementById('modalTitle').innerText = 'Tambah Role';
    document.getElementById('formData').action = '{{ route("master.role.store") }}';
    document.getElementById('methodField').innerHTML = '';
    ['can_create','can_read','can_update','can_delete','can_approve'].forEach(function(c) {
        document.getElementById(c).checked = false;
    });
}
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, kode, nama, deskripsi, c, r, u, d, a) {
    document.getElementById('modalTitle').innerText = 'Edit Role';
    document.getElementById('formData').action = '/master/role/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('kode').value = kode;
    document.getElementById('nama').value = nama;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('can_create').checked = c;
    document.getElementById('can_read').checked = r;
    document.getElementById('can_update').checked = u;
    document.getElementById('can_delete').checked = d;
    document.getElementById('can_approve').checked = a;
    openModal('modalForm');
}
</script>
@endpush
