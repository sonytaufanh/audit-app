@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div><h2 class="text-[22px] font-bold text-slate-900">Manajemen User</h2><p class="text-sm text-slate-500 mt-0.5">Kelola data pengguna aplikasi</p></div>
    <button onclick="openModal('modalForm')" class="btn-primary">+ Tambah User</button>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Email</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jabatan</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Role</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">BU</th><th class="text-left px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th><th class="text-center px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th></tr></thead>
        <tbody>
            @forelse($users as $u)
            <tr class="table-row">
                <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $u->name }}</td>
                <td class="px-6 py-3.5 text-xs">{{ $u->email }}</td>
                <td class="px-6 py-3.5">{{ $u->jabatan ?? '-' }}</td>
                <td class="px-6 py-3.5"><span class="badge badge-slate">{{ $u->role }}</span></td>
                <td class="px-6 py-3.5">{{ $u->businessUnit->nama ?? '-' }}</td>
                <td class="px-6 py-3.5"><span class="badge {{ $u->is_active ? 'badge-green' : 'badge-red' }}">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-6 py-3.5 text-center">
                    <button onclick="editData({{ $u->id }}, '{{ $u->name }}', '{{ $u->email }}', '{{ $u->jabatan }}', '{{ $u->role }}', {{ $u->business_unit_id ?? 'null' }})" class="text-primary-600 font-medium text-xs hover:text-primary-700 mr-4">Edit</button>
                    <button type="button" onclick="showDeleteConfirm(this)" data-action="{{ route('master.users.destroy', $u->id) }}" data-token="{{ csrf_token() }}" class="text-red-500 font-medium text-xs hover:text-red-600">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-16 text-center text-slate-400"><div class="font-medium">Belum ada data user</div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="modalForm" class="modal-overlay">
    <div class="modal-box p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-5"><h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah User</h3><button onclick="closeModal('modalForm')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
        <form id="formData" method="POST" action="{{ route('master.users.store') }}">@csrf<div id="methodField"></div>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama</label><input type="text" name="name" id="name" required maxlength="255" class="input-field"></div>
                    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Email</label><input type="email" name="email" id="email" required class="input-field"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Password</label><input type="password" name="password" id="password" required minlength="6" class="input-field"></div>
                    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Jabatan</label><input type="text" name="jabatan" id="jabatan" maxlength="100" class="input-field"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Role</label><select name="role" id="role" required class="input-field"><option value="">-- Pilih --</option>@foreach($roles as $r)<option value="{{ $r->nama }}">{{ $r->kode }} - {{ $r->nama }}</option>@endforeach</select></div>
                    <div><label class="text-xs font-semibold text-slate-500 mb-1.5 block">Business Unit</label><select name="business_unit_id" id="business_unit_id" class="input-field"><option value="">-- Pilih --</option>@foreach($businessUnits as $b)<option value="{{ $b->id }}">{{ $b->kode }} - {{ $b->nama }}</option>@endforeach</select></div>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6"><button type="button" onclick="closeModal('modalForm')" class="btn-secondary">Batal</button><button type="submit" class="btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.getElementById('formData').reset();
    document.getElementById('modalTitle').innerText = 'Tambah User';
    document.getElementById('formData').action = '{{ route("master.users.store") }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('password').required = true;
    document.getElementById('password').placeholder = '';
}
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function editData(id, name, email, jabatan, role, buId) {
    document.getElementById('modalTitle').innerText = 'Edit User';
    document.getElementById('formData').action = '/master/users/' + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('jabatan').value = jabatan || '';
    document.getElementById('role').value = role;
    document.getElementById('business_unit_id').value = buId === 'null' ? '' : buId;
    document.getElementById('password').required = false;
    document.getElementById('password').value = '';
    document.getElementById('password').placeholder = 'Kosongkan jika tidak diubah';
    openModal('modalForm');
}
</script>
@endpush
