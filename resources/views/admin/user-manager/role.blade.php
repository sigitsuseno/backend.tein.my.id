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
                    <h2 class="text-xl font-bold">Role List</h2>
                    <button id="btnAddRole"
                        class="bg-gradient-to-tr from-secondary to-primary text-white rounded-lg px-3 py-1 hover:opacity-80">
                        <i class='bx bx-plus'></i> Tambah
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table id="roleTable" class="min-w-full border border-primary/10 rounded-lg">
                        <thead class="bg-primary/10">
                            <tr>
                                <th class="px-3 py-2 text-left">#</th>
                                <th class="px-3 py-2 text-left">Role Name</th>
                                <th class="px-3 py-2 text-left">Level</th>
                                <th class="px-3 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="roleBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal Tambah/Edit Role -->
    <div id="roleModal" class="hidden fixed inset-0 bg-black/30 flex items-center justify-center z-50 transition">
        <div class="bg-white rounded-lg shadow-lg p-5 w-80 relative">
            <button class="absolute top-2 right-2 text-xl" id="closeModal">&times;</button>
            <h3 class="text-lg font-semibold mb-3" id="modalTitle">Tambah Role</h3>
            <form id="roleForm">
                @csrf
                <input type="hidden" id="role_id" name="id">
                <div class="mb-3">
                    <label for="name" class="text-sm font-medium">Role Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full border rounded px-2 py-1 mt-1 focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div class="mb-3">
                    <label for="slug" class="text-sm font-medium">Slug</label>
                    <input type="text" id="slug" name="slug" readonly
                        class="w-full border rounded px-2 py-1 mt-1 focus:outline-none focus:ring-1 focus:ring-primary bg-gray-100">
                </div>
                <div class="mb-3">
                    <label for="level" class="text-sm font-medium">Level</label>
                    <input type="number" id="level" name="level" min="1"
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
            loadRoles();

            function loadRoles() {
                $.get("{{ route('admin.user-manager.roles.index') }}", function(res) {
                    let html = '';
                    res.data.forEach((r, i) => {
                        html += `
                <tr class="border-b border-primary/10 hover:bg-gray-50">
                    <td class="px-3 py-2">${i + 1}</td>
                    <td class="px-3 py-2">${r.name}</td>
                    <td class="px-3 py-2">${r.level}</td>
                    <td class="hidden px-3 py-2">${r.guard_name ?? '-'}</td>
                    <td class="px-3 py-2 text-center">
                        <button class="editRole text-blue-600" data-id="${r.id}"><i class='bx bx-edit'></i></button>
                        <button class="deleteRole text-red-600 ml-2" data-id="${r.id}"><i class='bx bx-trash'></i></button>
                    </td>
                </tr>`;
                    });
                    $('#roleBody').html(html);
                });
            }

            // Tambah Role
            $('#btnAddRole').click(() => {
                $('#modalTitle').text('Tambah Role');
                $('#roleForm')[0].reset();
                $('#role_id').val('');
                $('#roleModal').removeClass('hidden');
            });

            $('#closeModal').click(() => $('#roleModal').addClass('hidden'));

            // Submit form
            $('#roleForm').submit(function(e) {
                e.preventDefault();
                const id = $('#role_id').val();
                const url = id ? `/admin/user-manager/roles/update/${id}` :
                    `/admin/user-manager/roles/store`;
                $.post(url, $(this).serialize(), function() {
                    $('#roleModal').addClass('hidden');
                    loadRoles();
                });
            });

            // Edit Role
            $(document).on('click', '.editRole', function() {
                const id = $(this).data('id');
                $.get(`/admin/user-manager/roles/edit/${id}`, function(res) {
                    const r = res.data;
                    $('#modalTitle').text('Edit Role');
                    $('#role_id').val(r.id);
                    $('#name').val(r.name);
                    $('#slug').val(r.slug);
                    $('#level').val(r.level);
                    $('#roleModal').removeClass('hidden');
                });
            });
            // Delete Role
            $(document).on('click', '.deleteRole', function() {
                if (confirm('Hapus role ini?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/admin/user-manager/roles/delete/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            loadRoles();
                        }
                    });
                }
            });
        });
    </script>
@endsection
