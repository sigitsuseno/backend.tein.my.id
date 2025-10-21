@extends('layouts.dash')

@section('content')
    @push('header')
        <div class="w-full h-full px-3 flex items-center justify-start ">
            <div>test</div>
        </div>
    @endpush
    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>@include('layouts.partials.aside')</div>
        <div class="p-3 md:p-6 bg-putih">
            <div class="w-full md:w-fit rounded-xl bg-white overflow-hidden p-1.5">
                @include('admin.user-manager.userm-menu')
            </div>

            <div class="w-full bg-white mt-4 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-bold">Role - Permission</h2>
                    <!-- kosongkan atau tambahkan button global -->
                </div>

                <div class="overflow-x-auto">
                    <table id="rpTable" class="min-w-full border border-primary/20 rounded-lg">
                        <thead class="bg-primary/10">
                            <tr>
                                <th class="px-3 py-2 text-left">#</th>
                                <th class="px-3 py-2 text-left">Role</th>
                                <th class="px-3 py-2 text-left">Slug</th>
                                <th class="px-3 py-2 text-left">Level</th>
                                <th class="px-3 py-2 text-center">Permissions</th>
                                <th class="px-3 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="rpBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal assign permissions -->
    <div id="assignModal" class="hidden fixed inset-0 bg-black/30 flex items-start justify-center z-50 pt-20">
        <div class="bg-white rounded-lg shadow-lg p-5 w-11/12 md:w-96 relative">
            <button class="absolute top-2 right-2 text-xl" id="closeAssignModal">&times;</button>
            <h3 class="text-lg font-semibold mb-3" id="assignModalTitle">Set Permissions</h3>

            <form id="assignForm">
                @csrf
                <input type="hidden" id="assign_role_id" name="role_id">

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Available Permissions</label>
                    <div id="permissionList" class="h-56 overflow-y-auto border rounded p-2">
                        <!-- checkboxes akan di-render via JS -->
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-tr from-secondary to-primary text-white rounded-md py-1.5">Simpan</button>
                    <button type="button" id="resetPermissions" class="flex-1 border rounded-md py-1.5">Batal</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            loadRolePermissionTable();

            function loadRolePermissionTable() {
                $.get("{{ route('admin.user-manager.role-permission.index') }}", function(res) {
                    let html = '';
                    res.data.forEach((r, i) => {
                        html += `
                <tr class="border-b border-primary/20 hover:bg-gray-50">
                    <td class="px-3 py-2">${i+1}</td>
                    <td class="px-3 py-2">${r.name}</td>
                    <td class="px-3 py-2">${r.slug}</td>
                    <td class="px-3 py-2">${r.level}</td>
                    <td class="px-3 py-2 text-center"><button class="viewPerm inline-block px-3 py-1 bg-primary/10 rounded" data-id="${r.id}">Lihat</button></td>
                    <td class="px-3 py-2 text-center">
                        <button class="editAssign inline-block px-3 py-1 bg-gradient-to-tr from-secondary to-primary text-white rounded" data-id="${r.id}">Set</button>
                    </td>
                </tr>`;
                    });
                    $('#rpBody').html(html);
                });
            }

            // open modal for editing assign
            $(document).on('click', '.editAssign', function() {
                const roleId = $(this).data('id');
                $('#assign_role_id').val(roleId);
                $('#assignModalTitle').text('Set Permissions for Role');
                $('#assignModal').removeClass('hidden');

                // load all permissions and which ones selected for role
                $.get("{{ url('/admin/user-manager/permissions') }}", function(pres) {
                    // pres.data = all permissions
                    $.get(`/admin/user-manager/role-permission/role/${roleId}`, function(rres) {
                        const currentPermIds = rres.data.permissions.map(p => p.id);
                        renderPermissionCheckboxes(pres.data, currentPermIds);
                    });
                });
            });

            // render checkboxes
            function renderPermissionCheckboxes(allPermissions, checkedIds) {
                let html = '';
                // optional grouping by group_name
                const groups = {};
                allPermissions.forEach(p => {
                    const g = p.group_name || 'other';
                    groups[g] = groups[g] || [];
                    groups[g].push(p);
                });

                for (const g in groups) {
                    html += `<div class="mb-2"><strong class="block mb-1">${g}</strong>`;
                    groups[g].forEach(p => {
                        const checked = checkedIds.includes(p.id) ? 'checked' : '';
                        html += `
                    <label class="flex items-center gap-2 mb-1">
                        <input type="checkbox" name="permission_ids[]" value="${p.id}" ${checked} />
                        <span class="text-sm">${p.name} <small class="text-xs text-gray-500">(${p.slug})</small></span>
                    </label>
                `;
                    });
                    html += `</div>`;
                }

                $('#permissionList').html(html);
            }

            // close modal
            $('#closeAssignModal, #resetPermissions').click(function() {
                $('#assignModal').addClass('hidden');
            });

            // submit assign form
            $('#assignForm').submit(function(e) {
                e.preventDefault();
                const data = $(this).serialize();
                $.post("{{ route('admin.user-manager.role-permission.assign') }}", data, function() {
                    $('#assignModal').addClass('hidden');
                    loadRolePermissionTable();
                    alert('Permissions updated.');
                }).fail(function(xhr) {
                    alert('Gagal, cek input. ' + (xhr.responseJSON?.message || ''));
                });
            });
        });
    </script>
@endsection
