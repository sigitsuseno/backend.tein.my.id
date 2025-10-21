@extends('layouts.dash')
@section('css')
@endsection
@section('content')
    @push('header')
        <div class="w-full h-full px-3 flex items-center justify-start ">
            <div class="flex justify-between items-center">
                <a href="{{ route('member.dashboard', $keyname) }}"
                    class="w-8 h-8 rounded-md bg-white flex items-center justify-center mr-2 hover:bg-secondary hover:text-white ">
                    <i class='bx bx-left-arrow-alt text-2xl'></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">My Profile</h2>
            </div>
        </div>
    @endpush
    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>
            @include('layouts.partials.aside-member')
        </div>
        <div class="p-3 md:p-6 bg-putih">

            @if (Auth::user()->status === 'registered')
                <div class="w-full px-6 py-4 bg-red-500  animate-bounce text-white mb-6">
                    <h2>Harap <span class="font-bold">Update Profile</span> terlebih dahulu !</h2>
                </div>
            @endif
            <div class="w-full rounded-2xl bg-gradient-to-br from-secondary to-light shadow mb-6 ">
                <div class="w-full h-12 flex items-center justify-between px-6">
                    <h1 class="text-white font-medium text-xl">Profile Info</h1>
                    <button data-modal-target="update_profile" type="button"
                        class="w-fit bg-primary text-white hover:bg-white hover:text-primary hover:ring hover:ring-primary font-medium py-1 px-4 rounded-lg transition-all duration-500 flex items-center shadow cursor-pointer">
                        <i class="bx bx-edit mr-2"></i> Update Profil
                    </button>
                </div>
                <div
                    class="w-full grid grid-cols-1 lg:grid-cols-4 gap-4 p-4 bg-gradient-to-t from-white to-white/10 rounded-2xl">
                    <div class="col-span-2 flex flex-col md:flex-row items-center justify-start gap-6 w-full p-2 relative">
                        <div class="w-24 md:w-32 aspect-square rounded-full bg-primary shrink-0 group relative">
                            <div data-modal-target="u_foto_profile" class="w-full h-full">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80"
                                    alt="Profile"
                                    class="w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                            </div>
                            {{-- <button type="button"
                                class="w-8 h-8 hidden items-center justify-center absolute bottom-0 right-0 group-hover:flex hover:bg-white rounded-md cursor-pointer"><i
                                    class='bx bx-edit-alt text-xl'></i></button> --}}
                        </div>
                        <div class="w-full  flex flex-col justify-between">
                            <div class="text-center md:text-left text-primary">
                                <h1 class="text-2xl text-primary font-bold underline">
                                    {{ $user_profile->details->nama_lengkap ?? $user_profile->name }}</h1>
                                <p class="text-primary -mt-1 text-sm">{{ $user_profile->uuid }}</p>
                                <p class="text-primary mt-2 flex items-center justify-center md:justify-start">
                                    <i class='bx bx-user mr-2'></i> {{ $user_profile->username ?? ' Username : - ' }}
                                </p>
                                <p class="text-primary flex items-center justify-center md:justify-start">
                                    <i class='bx bx-envelope mr-2'></i> {{ $user_profile->email }}
                                </p>
                                <p class="text-primary flex items-center justify-center md:justify-start md:mb-0">
                                    <i class='bx bxl-whatsapp mr-2'></i> {{ $user_profile->details->no_telp ?? '-' }}
                                </p>
                            </div>

                        </div>
                    </div>
                    <!-- Informasi Pribadi -->
                    <div class="col-span-2 bg-white rounded-2xl shadow-sm p-6 text-primary">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-primary/80">Tempat Lahir</p>
                                <p class="font-medium">{{ $user_profile->details->tempat_lahir ?? '' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-primary/80">Tanggal Lahir</p>
                                <p class="font-medium">
                                    {{ date('d F Y', strtotime($user_profile->details->tempat_lahir ?? '')) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-primary/80">Jenis Kelamin</p>
                                <p class="font-medium">{{ $user_profile->details->jenis_kelamin ?? '' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-primary/80">Kewarganegaraan</p>
                                <p class="font-medium">{{ $user_profile->details->warganegara ?? '' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-primary/80">Alamat</p>
                                <p class="font-medium">{{ $user_profile->details->alamat ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Kiri -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Medis -->
                    <div class="bg-white rounded-2xl shadow-sm ">
                        <div class="w-full h-12 px-6 flex justify-between items-center border-b border-primary/20">
                            <h3 class="text-xl font-bold text-gray-800">Informasi Medis</h3>
                            <button class="text-primary hover:text-blue-700">
                                <i class="bx bx-edit"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                            <div>
                                <p class="text-sm text-primary/80">Golongan Darah</p>
                                <p class="font-medium">O+</p>
                            </div>
                            <div>
                                <p class="text-sm text-primary/80">Tensi Darah</p>
                                <p class="font-medium">140/80</p>
                            </div>
                            <div>
                                <p class="text-sm text-primary/80">Alergi</p>
                                <p class="font-medium">Tidak ada alergi</p>
                            </div>
                            <div>
                                <p class="text-sm text-primary/80">Kondisi Medis</p>
                                <p class="font-medium">Tekanan darah tinggi</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-primary/80">Riwayat Penyakit</p>
                                <p class="font-medium">-</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-primary/80">Obat yang Dikonsumsi</p>
                                <p class="font-medium">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Vaksinasi Terbaru -->
                    <div class="bg-white rounded-2xl shadow-sm ">
                        <div class="w-full h-12 px-6 flex justify-between items-center border-b border-primary/20">
                            <h3 class="text-xl font-bold text-gray-800">Riwayat Vaksinasi Terbaru</h3>
                            <a href="#" class="text-primary hover:text-blue-700 text-sm font-medium">Lihat
                                Semua</a>
                        </div>
                        <div class="space-y-4 p-6 ">
                            <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                                <div>
                                    <p class="font-medium">COVID-19 Booster</p>
                                    <p class="text-sm text-primary/80">10 September 2023</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 ">Selesai</span>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                                <div>
                                    <p class="font-medium">Influenza</p>
                                    <p class="text-sm text-primary/80">25 Agustus 2023</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 ">Selesai</span>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-lg">
                                <div>
                                    <p class="font-medium">Hepatitis B</p>
                                    <p class="text-sm text-primary/80">15 Oktober 2023</p>
                                </div>
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 ">Terjadwal</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-6">
                    <!-- Status Akun -->
                    <div class="bg-white rounded-2xl shadow-sm ">
                        <div class="w-full h-12 px-6 flex justify-between items-center border-b border-primary/20">
                            <h3 class="text-xl font-bold text-gray-800">Status Akun</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $user_profile->status }}</span>
                            </div>
                            <p class="text-sm text-gray-600">Akun Anda terdaftar sejak <br>
                                {{ date('d F Y', strtotime($user_profile->created_at)) }}</p>
                            @if (Auth::user()->type === 'admin')
                                <button
                                    class="w-full bg-primary hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors mt-4">
                                    Cetak Kartu Pasien
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Dokumen -->
                    {{-- <div class="bg-white rounded-2xl shadow-sm ">
                        <div class="w-full h-12 px-6 flex justify-between items-center border-b border-primary/20">
                            <h3 class="text-xl font-bold text-gray-800">Dokumen</h3>
                            <button class="text-primary hover:text-blue-700">
                                <i class="bx bx-plus"></i>
                            </button>
                        </div>
                        <div class="space-y-3 p-6 ">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="bx bxs-file-pdf text-red-500 text-xl mr-3"></i>
                                <div class="flex-1">
                                    <p class="font-medium">Kartu BPJS</p>
                                    <p class="text-xs text-primary/80">Diunggah 15 Mei 2023</p>
                                </div>
                                <button class="text-primary hover:text-blue-700">
                                    <i class="bx bx-download"></i>
                                </button>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="bx bxs-file-pdf text-red-500 text-xl mr-3"></i>
                                <div class="flex-1">
                                    <p class="font-medium">KTP</p>
                                    <p class="text-xs text-primary/80">Diunggah 15 Mei 2023</p>
                                </div>
                                <button class="text-primary hover:text-blue-700">
                                    <i class="bx bx-download"></i>
                                </button>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="bx bx-file-image text-blue-500 text-xl mr-3"></i>
                                <div class="flex-1">
                                    <p class="font-medium">Hasil Lab</p>
                                    <p class="text-xs text-primary/80">Diunggah 10 Sep 2023</p>
                                </div>
                                <button class="text-primary hover:text-blue-700">
                                    <i class="bx bx-download"></i>
                                </button>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Pengingat -->
                    <div class="bg-white rounded-2xl shadow-sm">
                        <div class="w-full h-12 px-6 flex justify-between items-center border-b border-primary/20">
                            <h3 class="text-xl font-bold text-gray-800">Reminder</h3>
                        </div>
                        <div class="space-y-3 p-6 ">
                            <div class="flex items-start">
                                <i class="bx bx-bell text-yellow-500 mt-1 mr-3"></i>
                                <div>
                                    <p class="font-medium">Vaksinasi Hepatitis B</p>
                                    <p class="text-sm text-primary/80">15 Oktober 2023, 10:00 WIB</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="bx bx-calendar-check text-green-500 mt-1 mr-3"></i>
                                <div>
                                    <p class="font-medium">Konsultasi Rutin</p>
                                    <p class="text-sm text-primary/80">30 Oktober 2023, 14:30 WIB</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="bx bxs-thermometer text-purple-500 mt-1 mr-3"></i>
                                <div>
                                    <p class="font-medium">Pemeriksaan Tekanan Darah</p>
                                    <p class="text-sm text-primary/80">Setiap bulan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Darurat -->
                    <div class="bg-white rounded-2xl shadow-sm">
                        <div class="w-full h-12 px-6 flex justify-between items-center border-b border-primary/20">
                            <h3 class="text-xl font-bold text-gray-800">Kontak Darurat</h3>
                            <div x-data="{ openKontak: false }">
                                <button id="btnTambahKontak" @click="openKontak = true; resetForm()"
                                    class="px-3 py-1 bg-red-600 text-white rounded-md"><i class='bx bx-plus'></i></button>

                                <div x-show="openKontak"
                                    class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center">
                                    <div @click.outside="openKontak = false"
                                        class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6">
                                        <h2 class="text-xl font-bold mb-4">Kontak Darurat</h2>
                                        <form id="formKontakDarurat" class="space-y-3">
                                            @csrf
                                            <input type="hidden" name="id" id="kontak_id">
                                            <div>
                                                <label class="block text-sm font-medium">Nama</label>
                                                <input type="text" name="nama" id="nama"
                                                    class="w-full border rounded-md p-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium">Hubungan</label>
                                                <input type="text" name="hubungan" id="hubungan"
                                                    class="w-full border rounded-md p-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium">No Telepon</label>
                                                <input type="text" name="no_telp" id="no_telp"
                                                    class="w-full border rounded-md p-2">
                                            </div>
                                            <div class="flex justify-end space-x-2 mt-4">
                                                <button type="button" @click="openKontak = false"
                                                    class="px-3 py-2 border rounded-md">Batal</button>
                                                <button type="submit"
                                                    class="px-3 py-2 bg-red-600 text-white rounded-md">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-y-3 p-6">
                            @foreach ($user_profile->kontakDarurat as $k)
                                <div class="p-3 bg-red-50 rounded-lg flex justify-between items-start">
                                    <div>
                                        <p class="font-medium">{{ $k->nama }}</p>
                                        <p class="text-sm text-gray-600">{{ $k->hubungan }}</p>
                                        <p class="text-sm text-gray-600 flex items-center mt-1">
                                            <i class="bx bx-phone mr-2"></i> {{ $k->no_telp }}
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="btnEditKontak text-primary" data-id="{{ $k->id }}"
                                            data-nama="{{ $k->nama }}" data-hubungan="{{ $k->hubungan }}"
                                            data-no_telp="{{ $k->no_telp }}">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btnDeleteKontak text-red-500" data-id="{{ $k->id }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div data-modal-backdrop="update_profile" data-modal-backdrop-close="true"
        class="pointer-events-none fixed inset-0 z-[999] w-full h-screen px-3 md:px-0 flex justify-center items-center bg-primary/50 bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300">
        <div data-dialog="update_profile" class="relative p-4 w-full max-w-2xl rounded-lg bg-white shadow-sm">

            <h2 class="text-xl font-bold mb-4">Update Profil</h2>
            <form class="space-y-3">
                @csrf

                <div class="w-full grid grid-cols-1 lg:grid-cols-[180px_1fr] items-center relative">
                    <label for="nama_lengkap" class="block text-sm/4 font-medium text-gray-700 mb-1">
                        Nama Lengkap
                        <span class="pl-1 text-[8px]">(Sesuai KTP)</span>
                    </label>
                    <div class="w-full">
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $user_profile->details->nama_lengkap ?? '') }}"
                            class="w-full px-3 h-8 lg:h-9 text-sm ring outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary/50 rounded-lg">
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="w-full grid grid-cols-1 lg:grid-cols-[180px_1fr] items-center relative">
                    <label for="tempat_lahir" class="block text-sm/4 font-medium text-gray-700 mb-1 md:flex">Tempat
                        Lahir <span class="pl-1 text-[8px]">(Sesuai KTP)</span></label>
                    <div class="absolute bottom-0 left-0 text-[8px]"></div>
                    <div class="w-full">
                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir', $user_profile->details->tempat_lahir ?? '') }}"
                            class="w-full px-3 h-8 lg:h-9 text-sm ring outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary/50 rounded-lg">
                        @error('tempat_lahir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-full grid grid-cols-1 lg:grid-cols-[180px_1fr] items-center relative">
                    <label class="block text-sm/4 font-medium text-gray-700 mb-1">
                        Tanggal Lahir
                        <span class="pl-1 text-[8px]">(Sesuai KTP)</span>
                    </label>
                    @php
                        $tglLahirDb = $user_profile->details->tanggal_lahir ?? null;
                        $selectedDay = old('tanggal_lahir_day');
                        $selectedMonth = old('tanggal_lahir_month');
                        $selectedYear = old('tanggal_lahir_year');

                        if (!$selectedDay && $tglLahirDb && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tglLahirDb)) {
                            $date = \Carbon\Carbon::parse($tglLahirDb);
                            $selectedDay = $date->day;
                            $selectedMonth = $date->month;
                            $selectedYear = $date->year;
                        }

                        $currentYear = date('Y');
                        $startYear = 1950;
                    @endphp

                    <div class="w-full grid grid-cols-3 gap-3">
                        <select name="tanggal_lahir_day" id="tanggal_lahir_day"
                            class="w-full px-1 h-9 text-sm ring rounded-lg outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary/50 ">
                            <option value="" disabled {{ !$selectedDay ? 'selected' : '' }}>Tanggal</option>
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}"
                                    {{ (int) $selectedDay === $d ? 'selected' : '' }}>
                                    {{ str_pad($d, 2, '0', STR_PAD_LEFT) }}
                                </option>
                            @endfor
                        </select>

                        <select name="tanggal_lahir_month" id="tanggal_lahir_month"
                            class="w-full px-1 h-9 text-sm ring rounded-lg outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary/50 ">
                            <option value="" disabled {{ !$selectedMonth ? 'selected' : '' }}>Bulan</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                    {{ (int) $selectedMonth === $m ? 'selected' : '' }}>
                                    {{ date('M', mktime(0, 0, 0, $m, 10)) }}
                                </option>
                            @endfor
                        </select>

                        <select name="tanggal_lahir_year" id="tanggal_lahir_year"
                            class="w-full px-1 h-9 text-sm ring rounded-lg outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary/50 ">
                            <option value="" disabled {{ !$selectedYear ? 'selected' : '' }}>Tahun</option>
                            @for ($y = $currentYear; $y >= $startYear; $y--)
                                <option value="{{ $y }}" {{ (int) $selectedYear === $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    {{-- Pesan error umum jika salah satu bagian tanggal gagal validasi di Controller --}}
                    @if (
                        $errors->has('tanggal_lahir_day') ||
                            $errors->has('tanggal_lahir_month') ||
                            $errors->has('tanggal_lahir_year') ||
                            $errors->has('tanggal_lahir'))
                        <p class="text-red-500 text-xs mt-1">Tanggal lahir tidak valid.</p>
                    @endif
                </div>
                <div class="w-full grid grid-cols-1 lg:grid-cols-[180px_1fr] items-center relative">
                    <span>Jenis Kelamin</span>
                    {{-- PERBAIKAN: Menambahkan logic old() agar nilai terpilih tetap ada saat validasi gagal --}}
                    @php $jk = old('jenis_kelamin', $user_profile->details->jenis_kelamin ?? ''); @endphp
                    <div class="w-full grid grid-cols-2 items-center h-9">
                        <label for="laki_laki" class="flex items-center gap-3">
                            <input type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki"
                                {{ $jk === 'Laki-laki' ? 'checked' : '' }}>
                            <span>Laki-laki</span>
                        </label>
                        <label for="perempuan" class="flex items-center gap-3">
                            <input type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan"
                                {{ $jk === 'Perempuan' ? 'checked' : '' }}>
                            <span>Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-xs mt-1 col-span-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full grid grid-cols-1 lg:grid-cols-[180px_1fr] items-center relative">
                    <label for="no_telp" class="block text-sm/4 font-medium text-gray-700 mb-1">
                        Nomer Telp/WA
                    </label>
                    <div class="w-full">
                        <input type="text" id="no_telp" name="no_telp"
                            value="{{ old('no_telp', $user_profile->details->no_telp ?? '') }}"
                            class="w-full px-3 h-8 lg:h-9 text-sm ring outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary/50 rounded-lg">
                        @error('no_telp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="w-full grid grid-cols-1 lg:grid-cols-[180px_1fr] items-center relative">
                    <label for="warganegara" class="block text-sm/4 font-medium text-gray-700 mb-1">
                        Warga Negara
                    </label>
                    <div class="w-full">
                        <input type="text" id="warganegara" name="warganegara"
                            value="{{ old('warganegara', $user_profile->details->warganegara ?? '') }}"
                            class="w-full px-3 h-8 lg:h-9 text-sm ring outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary/50 rounded-lg">
                        @error('warganegara')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="w-full grid grid-cols-1 lg:grid-cols-[180px_1fr] items-center relative">
                    <label for="alamat" class="block text-sm/4 font-medium text-gray-700 mb-1">Alamat
                        Lengkap
                        <span class="pl-1 text-[8px]">(Sesuai KTP)</span>
                    </label>

                    <div class="w-full">
                        {{-- PERBAIKAN: Menghapus attribute 'value' dan memindahkan nilai ke dalam tag textarea --}}
                        <textarea id="alamat" name="alamat"
                            class="w-full px-3 py-1 text-sm ring outline-none focus:bg-white focus:ring ring-secondary focus:ring-primary rounded-lg"
                            rows="4">{{ old('alamat', $user_profile->details->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" data-dismiss="update_profile"
                        class="px-3 py-2 border rounded-md">Batal</button>
                    <button id="submit_editprofile" class="px-3 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                </div>
            </form>

        </div>
    </div>
    <div data-modal-backdrop="u_foto_profile" data-modal-backdrop-close="true"
        class="pointer-events-none fixed inset-0 z-[999] w-full h-screen px-3 md:px-0 flex justify-center items-center bg-primary/50 bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300">
        <div data-dialog="u_foto_profile" class="relative w-full max-w-2xl rounded-lg bg-white shadow-sm">
            <div class="w-full h-12 px-4 items-center">
                <h2 class="text-xl font-bold mb-4">Update Foto Profil</h2>
            </div>
            <form class="space-y-3">
                @csrf
                <div class="p-4">

                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" data-dismiss="u_foto_profile"
                            class="px-3 py-2 border rounded-md">Batal</button>
                        <button id="submit_editprofile"
                            class="px-3 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                    </div>
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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            $('#submit_editprofile').on('click', function(e) {
                e.preventDefault()
                let tanggal_lahir_day = $('#tanggal_lahir_day').val()
                let tanggal_lahir_month = $('#tanggal_lahir_month').val()
                let tanggal_lahir_year = $('#tanggal_lahir_year').val()
                let tanggalKelahiran = tanggal_lahir_year + '-' + tanggal_lahir_month + '-' +
                    tanggal_lahir_day;
                let detailProfile = {
                    nama_lengkap: $('#nama_lengkap').val(),
                    tempat_lahir: $('#tempat_lahir').val(),
                    tanggal_lahir: tanggalKelahiran,
                    jenis_kelamin: $('input[name="jenis_kelamin"]:checked').val(),
                    no_telp: $('#no_telp').val(),
                    warganegara: $('#warganegara').val(),
                    alamat: $('#alamat').val(),
                    // _token: $("meta[name='csrf-token']").attr('content'),
                }
                console.log(detailProfile);

                $.ajax({
                    url: '{{ route('member.profile.detail.update', ['keyname' => Auth::user()->username ?? Auth::user()->uuid]) }}',
                    method: 'POST',
                    data: detailProfile,
                    dataType: 'json',
                    success: (res) => {
                        console.log(res);

                        Toast.fire({
                            icon: "success",
                            title: "Signed in successfully"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    },
                    error: (err) => {
                        console.log(err);
                        alert('Gagal memperbarui profil. Silakan cek console untuk detail.');
                    }
                });
            });
        })
    </script>
@endsection
