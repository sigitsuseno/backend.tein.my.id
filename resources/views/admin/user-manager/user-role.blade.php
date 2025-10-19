@extends('layouts.dash')

@section('content')
    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>@include('layouts.partials.aside')</div>
        <div class="p-3 md:p-6 bg-putih">
            <div class="w-full md:w-fit rounded-xl bg-white overflow-hidden p-1.5">
                @include('admin.user-manager.userm-menu')
            </div>

            <div class="w-full bg-white mt-4 rounded-xl ">
                <div class="w-full border-b border-primary/20">
                    <div class="w-full lg:w-1/2 h-10 grid grid-cols-2 pl-1 pt-1 ">
                        <a href="{{ route('admin.user-manager.index') }}"
                            class="w-full h-full rounded-t-lg flex items-center justify-center font-semibold {{ request()->routeIs('admin.user-manager.index') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} px-4">
                            User Management</a>
                        <a href="{{ route('admin.user-manager.user-role.page') }}"
                            class="w-full h-full rounded-t-lg flex items-center justify-center font-semibold {{ request()->routeIs('admin.user-manager.user-role.page') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} px-4">
                            Assign Role
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-bold">User Role Management</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="userRoleTable" class="min-w-full border border-primary/20 rounded-lg">
                            <thead class="bg-primary/10">
                                <tr>
                                    <th class="px-3 py-2 text-left">#</th>
                                    <th class="px-3 py-2 text-left">Nama</th>
                                    <th class="px-3 py-2 text-left">Email</th>
                                    <th class="px-3 py-2 text-left">Roles</th>
                                    <th class="px-3 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="userRoleBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal Assign Role -->
    <div id="userRoleModal" class="hidden fixed inset-0 bg-black/30 flex items-start justify-center z-50 pt-20">
        <div class="bg-white rounded-lg shadow-lg p-5 w-96 relative">
            <button class="absolute top-2 right-2 text-xl" id="closeUserRoleModal">&times;</button>
            <h3 class="text-lg font-semibold mb-3">Set Roles for User</h3>

            <form id="userRoleForm">
                @csrf
                <input type="hidden" id="user_id" name="user_id">

                <div id="roleCheckboxList" class="max-h-60 overflow-y-auto border rounded p-2"></div>

                <div class="flex gap-2 mt-3">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-tr from-secondary to-primary text-white rounded-md py-1.5">Simpan</button>
                    <button type="button" id="cancelUserRole" class="flex-1 border rounded-md py-1.5">Batal</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            loadUsers();

            function loadUsers() {
                $.get("{{ route('admin.user-manager.user-role.index') }}", function(res) {
                    let html = '';
                    res.data.forEach((u, i) => {
                        const roles = u.roles.map(r =>
                            `<span class='bg-primary/10 px-2 py-0.5 rounded text-sm'>${r.name}</span>`
                        ).join(' ');
                        html += `
                <tr class="border-b border-primary/20 hover:bg-gray-50">
                    <td class="px-3 py-2">${i+1}</td>
                    <td class="px-3 py-2">${u.name}</td>
                    <td class="px-3 py-2">${u.email}</td>
                    <td class="px-3 py-2">${roles || '-'}</td>
                    <td class="px-3 py-2 text-center">
                        <button class="setRole text-white bg-gradient-to-tr from-secondary to-primary rounded px-3 py-1" data-id="${u.id}">Set</button>
                    </td>
                </tr>`;
                    });
                    $('#userRoleBody').html(html);
                });
            }

            $(document).on('click', '.setRole', function() {
                const userId = $(this).data('id');
                $('#user_id').val(userId);
                $('#userRoleModal').removeClass('hidden');

                $.get(`/admin/user-manager/user-role/${userId}`, function(res) {
                    const roles = res.all_roles;
                    const userRoles = res.data.roles.map(r => r.id);
                    let html = '';
                    roles.forEach(r => {
                        const checked = userRoles.includes(r.id) ? 'checked' : '';
                        html += `
                    <label class="flex items-center gap-2 mb-1">
                        <input type="checkbox" name="role_ids[]" value="${r.id}" ${checked}>
                        <span>${r.name} <small class="text-xs text-gray-500">(${r.slug})</small></span>
                    </label>`;
                    });
                    $('#roleCheckboxList').html(html);
                });
            });

            $('#closeUserRoleModal, #cancelUserRole').click(() => $('#userRoleModal').addClass('hidden'));

            $('#userRoleForm').submit(function(e) {
                e.preventDefault();
                $.post("{{ route('admin.user-manager.user-role.assign') }}", $(this).serialize(),
                    function() {
                        $('#userRoleModal').addClass('hidden');
                        loadUsers();
                    });
            });
        });
    </script>
@endsection
