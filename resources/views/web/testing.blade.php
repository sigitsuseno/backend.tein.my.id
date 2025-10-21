<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien | Klinik Sehat Selalu</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-700">Dashboard Pasien</h1>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-700">Halo, <span id="patient-name">Tengku Ahmad</span></p>
                    <p class="text-xs text-gray-500">Pasien ID: <span id="patient-id">PSN-1023</span></p>
                </div>
                <img src="https://i.pravatar.cc/40" alt="Avatar" class="rounded-full border border-gray-300">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-6">

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white shadow rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Status Vaksinasi</p>
                    <p class="text-lg font-semibold text-green-600">Lengkap</p>
                </div>
                <i class="fa-solid fa-syringe text-green-500 text-2xl"></i>
            </div>

            <div class="bg-white shadow rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Jadwal Berikutnya</p>
                    <p class="text-lg font-semibold text-blue-600">22 Okt 2025</p>
                </div>
                <i class="fa-solid fa-calendar-days text-blue-500 text-2xl"></i>
            </div>

            <div class="bg-white shadow rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Vaksinasi</p>
                    <p class="text-lg font-semibold text-indigo-600">3</p>
                </div>
                <i class="fa-solid fa-clipboard-list text-indigo-500 text-2xl"></i>
            </div>
        </div>

        <!-- Riwayat Vaksin -->
        <div class="bg-white shadow rounded-xl p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Riwayat Vaksinasi</h2>
                <button id="book-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                    + Book Jadwal Vaksin
                </button>
            </div>
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jenis Vaksin</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="vaccine-history">
                    <tr class="border-t">
                        <td class="px-4 py-2">01 Jan 2025</td>
                        <td class="px-4 py-2">COVID-19 Booster</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">Selesai</td>
                        <td class="px-4 py-2">Tidak ada efek samping</td>
                    </tr>
                    <tr class="border-t">
                        <td class="px-4 py-2">10 Mar 2025</td>
                        <td class="px-4 py-2">Influenza</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">Selesai</td>
                        <td class="px-4 py-2">Baik</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <!-- Modal Booking -->
    <div id="booking-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white rounded-xl w-full max-w-md shadow-lg">
            <div class="border-b px-4 py-2 flex justify-between items-center">
                <h3 class="font-semibold text-lg">Book Jadwal Vaksin</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div class="p-4">
                <form id="booking-form">
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Pilih Jenis Vaksin</label>
                        <select id="vaccine-type" class="w-full border rounded-lg px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="Covid-19 Booster">COVID-19 Booster</option>
                            <option value="Influenza">Influenza</option>
                            <option value="Hepatitis B">Hepatitis B</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Tanggal Vaksin</label>
                        <input type="date" id="vaccine-date" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div class="text-right">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a2b4b1e76f.js" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('#book-btn').click(function() {
                $('#booking-modal').fadeIn(200);
            });

            $('#close-modal').click(function() {
                $('#booking-modal').fadeOut(200);
            });

            $('#booking-form').on('submit', function(e) {
                e.preventDefault();

                let type = $('#vaccine-type').val();
                let date = $('#vaccine-date').val();

                if (!type || !date) {
                    alert('Lengkapi data terlebih dahulu!');
                    return;
                }

                // Simulasi penyimpanan booking
                let newRow = `
                    <tr class="border-t bg-yellow-50">
                        <td class="px-4 py-2">${date}</td>
                        <td class="px-4 py-2">${type}</td>
                        <td class="px-4 py-2 text-yellow-600 font-semibold">Menunggu Konfirmasi</td>
                        <td class="px-4 py-2">Booking baru</td>
                    </tr>
                `;

                $('#vaccine-history').prepend(newRow);
                $('#booking-modal').fadeOut(200);
                $('#booking-form')[0].reset();

                alert('Jadwal vaksin berhasil di-book!');
            });
        });
    </script>
</body>

</html>
