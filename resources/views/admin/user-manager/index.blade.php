@extends('layouts.dash')

@section('content')
    {{-- Pastikan ini di-include dengan benar --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @push('header')
        <div class="w-full h-full px-3 flex items-center justify-start lg:bg-white">
            <div>test</div>
        </div>
    @endpush

    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>@include('layouts.partials.aside')</div>
        <div class="p-3 md:p-6 bg-putih">
            <div class="w-full md:w-fit rounded-xl bg-white overflow-hidden p-1.5">
                @include('admin.user-manager.userm-menu')
            </div>

            <div class="w-full bg-white mt-4 rounded-xl ">
                <div class="w-full border-b border-primary/10">
                    <div class="w-full lg:w-1/2 h-10 grid grid-cols-2 pl-1 pt-1 ">

                        <a href="{{ route('admin.user-manager.index') }}"
                            class="w-full h-full rounded-t-lg flex items-center justify-center font-semibold {{ request()->routeIs('admin.user-manager.index') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} px-4">User
                            Management</a>
                        <a href="{{ route('admin.user-manager.user-role.page') }}"
                            class="w-full h-full rounded-t-lg flex items-center justify-center font-semibold {{ request()->routeIs('admin.user-manager.user-role.page') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} px-4">
                            Assign Role
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-bold">User Management</h2>
                        <button id="btnAddUser"
                            class="bg-gradient-to-tr from-secondary to-primary text-white rounded-lg px-3 py-1 hover:opacity-80">
                            <i class='bx bx-plus'></i> Tambah
                        </button>
                    </div>

                    <div class="overflow-x-auto">

                        <table id="userTable" class="min-w-full border border-primary/20 rounded-lg">
                            <thead class="bg-primary/10">
                                <tr>
                                    <th class="px-3 py-2 text-left">#</th>
                                    <th class="px-3 py-2 text-left">Nama</th>
                                    <th class="px-3 py-2 text-left">Email</th>
                                    <th class="px-3 py-2 text-left">Password</th>
                                    <th class="px-3 py-2 text-left">Type</th>
                                    <th class="px-3 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="userDataTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL BARU: Menggunakan Tailwind CSS untuk tampilan dan jQuery untuk logic show/hide --}}
    <div id="userModal" class="hidden fixed inset-0 bg-black/50 flex items-start justify-center z-50 pt-10">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-11/12 max-w-lg relative">

            {{-- Tombol Close Modal --}}
            <button type="button" id="btnCloseModal"
                class="absolute top-3 right-3 text-2xl text-gray-400 hover:text-red-500 transition duration-150">&times;</button>

            <form id="formUser">
                <input type="hidden" name="id" id="user_id_hidden">
                <div class="modal-header border-b pb-3 mb-4">
                    <h5 class="text-xl font-semibold" id="userModalLabel">Tambah User Baru</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="name" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-secondary focus:border-secondary transition duration-150">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-secondary focus:border-secondary transition duration-150">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1" id="passwordLabel">Password</label>
                        <input type="password" name="password" required id="passwordInput"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-secondary focus:border-secondary transition duration-150">
                        <p id="passwordHint" class="text-xs text-gray-500 mt-1 hidden">Kosongkan jika tidak ingin mengubah
                            password.</p>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-secondary focus:border-secondary transition duration-150">
                            <option value="">-- pilih tipe --</option>
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer pt-4 border-t mt-4 flex justify-end">
                    <button type="submit"
                        class="bg-gradient-to-tr from-secondary to-primary text-white rounded-lg px-4 py-2 font-semibold hover:opacity-90 transition duration-150">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function showModal() {
                $('#userModal').removeClass('hidden');
            }

            function hideModal() {
                $('#userModal').addClass('hidden');
                $('#formUser')[0].reset();
                $('#formUser').removeAttr('data-id');
            }

            // Bind tombol tutup modal
            $('#btnCloseModal').on('click', hideModal);

            function loadUserData() {
                $.ajax({
                    url: "{{ route('admin.user-manager.user') }}",
                    method: "GET",
                    success: function(res) {
                        let data = res.userData;
                        let rows = '';
                        $.each(data, function(index, user) {
                            rows += `
                            <tr class="border-b border-primary/10 hover:bg-gray-50">
                            <td class="px-3 py-2">${index + 1}</td>
                            <td class="px-3 py-2">${user.name}</td>
                            <td class="px-3 py-2">${user.email}</td>
                            <td class="px-3 py-2 text-gray-400">********</td>
                            <td class="px-3 py-2">${user.type ?? '-'}</td>
                            <td class="text-center px-3 py-2 space-x-2">
                                <button type="button" class="text-blue-600 hover:text-blue-800 transition btnEdit" data-id="${user.id}" title="Edit User">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-800 transition btnDelete" data-id="${user.id}" title="Hapus User">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                            </tr>
                        `;
                        });
                        $('#userDataTable').html(rows);
                    },
                    error: function(xhr, status, error) {
                        console.error("Gagal memuat data:", error);
                        $('#userDataTable').html(
                            '<tr><td colspan="6" class="text-center py-4 text-red-500">Gagal memuat data.</td></tr>'
                        );
                    }
                });
            }
            loadUserData();

            // ========== CREATE (Buka Modal) ==========
            $('#btnAddUser').on('click', function() {
                $('#userModalLabel').text('Tambah User Baru');
                $('#formUser')[0].reset();
                $('#formUser').attr('data-mode', 'create');
                $('#user_id_hidden').val('');

                // Password wajib diisi saat mode CREATE
                $('#passwordInput').prop('required', true);
                $('#passwordLabel').text('Password');
                $('#passwordHint').addClass('hidden');

                showModal(); // Tampilkan modal
            });

            // ========== SUBMIT (CREATE & UPDATE) ==========
            $('#formUser').on('submit', function(e) {
                e.preventDefault();

                let mode = $(this).attr('data-mode');
                let id = $(this).attr('data-id');
                let url = mode === 'edit' ?
                    "{{ url('admin/user-manager/update') }}/" + id :
                    "{{ route('admin.user-manager.store') }}";

                $.ajax({
                    url: url,
                    method: "POST", // Laravel akan menangani PUT/PATCH via POST jika ada method field di form
                    data: $(this).serialize(),
                    success: function(res) {
                        // Cek property 'success' yang dikirim dari Controller
                        if (res.success) {
                            hideModal(); // Sembunyikan modal
                            loadUserData();
                            alert(res.message);
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                        let msg = 'Gagal menyimpan data: ';
                        if (errors) {
                            for (let key in errors) msg += errors[key][0] + "\n";
                        } else if (xhr.status === 500) {
                            msg +=
                                "Internal Server Error. Cek log Laravel Anda (storage/logs/laravel.log).";
                        } else {
                            msg += "Terjadi kesalahan yang tidak diketahui.";
                        }
                        alert(msg);
                    }
                });
            });

            // ========== EDIT (Buka Modal) ==========
            $(document).on('click', '.btnEdit', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ url('admin/user-manager/edit') }}/" + id,
                    method: "GET",
                    success: function(res) {
                        // Pastikan Controller merespons dengan properti 'user' (bukan 'data')
                        let user = res.user || res.data;

                        $('#userModalLabel').text('Edit User: ' + user.name);
                        $('#formUser').attr('data-mode', 'edit').attr('data-id', user.id);
                        $('#user_id_hidden').val(user.id);

                        $('[name="name"]').val(user.name);
                        $('[name="email"]').val(user.email);
                        $('[name="type"]').val(user.type);

                        // Password tidak wajib diisi saat mode EDIT
                        $('#passwordInput').val('').prop('required', false);
                        $('#passwordLabel').text('Password (Opsional)');
                        $('#passwordHint').removeClass('hidden');

                        showModal(); // Tampilkan modal
                    },
                    error: function() {
                        alert("Gagal memuat data user untuk diedit.");
                    }
                });
            });

            // ========== DELETE ==========
            $(document).on('click', '.btnDelete', function() {
                // Mengganti confirm() dengan alert untuk kepatuhan environment
                if (!confirm('Yakin ingin menghapus user ini?')) return;
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ url('admin/user-manager/delete') }}/" + id,
                    method: "DELETE",
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            loadUserData();
                        }
                    },
                    error: function() {
                        alert('Gagal menghapus user.');
                    }
                });
            });

        });
    </script>
@endsection
