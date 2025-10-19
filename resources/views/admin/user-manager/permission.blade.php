@extends('layouts.dash')

@section('content')
    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>
            @include('layouts.partials.aside')
        </div>
        <div class="p-3 md:p-6 bg-putih">
            <div class="w-full md:w-fit rounded-xl bg-white overflow-hidden p-1.5">
                @include('admin.user-manager.userm-menu')
            </div>

            <div class="w-full bg-white mt-4 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-bold">Permission List</h2>
                    <button id="btnAddPermission"
                        class="bg-gradient-to-tr from-secondary to-primary text-white rounded-lg px-3 py-1 hover:opacity-80">
                        <i class='bx bx-plus'></i> Tambah
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table id="permissionTable" class="min-w-full border border-primary/10 rounded-lg">
                        <thead class="bg-primary/10">
                            <tr>
                                <th class="px-3 py-2 text-left">#</th>
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Slug</th>
                                <th class="px-3 py-2 text-left">Group</th>
                                <th class="px-3 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="permissionBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal Tambah/Edit Permission -->
    <div id="permissionModal" class="hidden fixed inset-0 bg-black/30 flex items-center justify-center z-50 transition">
        <div class="bg-white rounded-lg shadow-lg p-5 w-80 relative">
            <button class="absolute top-2 right-2 text-xl" id="closePermissionModal">&times;</button>
            <h3 class="text-lg font-semibold mb-3" id="permissionModalTitle">Tambah Permission</h3>
            <form id="permissionForm">
                @csrf
                <input type="hidden" id="permission_id" name="id">
                <div class="mb-3">
                    <label for="name" class="text-sm font-medium">Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full border rounded px-2 py-1 mt-1 focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div class="mb-3">
                    <label for="slug" class="text-sm font-medium">Slug</label>
                    <input type="text" id="slug" name="slug" readonly
                        class="w-full border rounded px-2 py-1 mt-1 focus:outline-none focus:ring-1 focus:ring-primary bg-gray-100">
                </div>
                <div class="mb-3">
                    <label for="group_name" class="text-sm font-medium">Group</label>
                    <input type="text" id="group_name" name="group_name"
                        class="w-full border rounded px-2 py-1 mt-1 focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-tr from-secondary to-primary text-white rounded-md py-1.5 hover:opacity-80">
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            loadPermissions();

            function loadPermissions() {
                $.get("{{ route('admin.user-manager.permissions.index') }}", function(res) {
                    let html = '';
                    res.data.forEach((p, i) => {
                        html += `
                <tr class="border-b border-primary/10 hover:bg-gray-50">
                    <td class="px-3 py-2">${i + 1}</td>
                    <td class="px-3 py-2">${p.name}</td>
                    <td class="px-3 py-2">${p.slug}</td>
                    <td class="px-3 py-2">${p.group_name ?? '-'}</td>
                    <td class="px-3 py-2 text-center">
                        <button class="editPermission text-blue-600" data-id="${p.id}"><i class='bx bx-edit'></i></button>
                        <button class="deletePermission text-red-600 ml-2" data-id="${p.id}"><i class='bx bx-trash'></i></button>
                    </td>
                </tr>`;
                    });
                    $('#permissionBody').html(html);
                });
            }

            $('#btnAddPermission').click(() => {
                $('#permissionModalTitle').text('Tambah Permission');
                $('#permissionForm')[0].reset();
                $('#permission_id').val('');
                $('#permissionModal').removeClass('hidden');
            });

            $('#closePermissionModal').click(() => $('#permissionModal').addClass('hidden'));

            $('#permissionForm').submit(function(e) {
                e.preventDefault();
                const id = $('#permission_id').val();
                const url = id ? `/admin/user-manager/permissions/update/${id}` :
                    `/admin/user-manager/permissions/store`;
                $.post(url, $(this).serialize(), function() {
                    $('#permissionModal').addClass('hidden');
                    loadPermissions();
                });
            });

            $(document).on('click', '.editPermission', function() {
                const id = $(this).data('id');
                $.get(`/admin/user-manager/permissions/edit/${id}`, function(res) {
                    const p = res.data;
                    $('#permissionModalTitle').text('Edit Permission');
                    $('#permission_id').val(p.id);
                    $('#name').val(p.name);
                    $('#slug').val(p.slug);
                    $('#group_name').val(p.group_name);
                    $('#permissionModal').removeClass('hidden');
                });
            });

            $(document).on('click', '.deletePermission', function() {
                if (confirm('Hapus permission ini?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/admin/user-manager/permissions/delete/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            loadPermissions();
                        }
                    });
                }
            });
        });
    </script>
@endsection
