<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien - Klinik Sehat Bahagia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c7fb8;
            --secondary: #7fcdbb;
            --accent: #edf8b1;
            --light: #f7f7f7;
            --dark: #253237;
            --success: #4CAF50;
            --warning: #FF9800;
            --danger: #F44336;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, var(--primary), #1a5a8a);
            color: white;
            padding: 20px 0;
            transition: all 0.3s;
        }

        .logo {
            display: flex;
            align-items: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo i {
            font-size: 24px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 20px;
            font-weight: 600;
        }

        .nav-links {
            margin-top: 20px;
        }

        .nav-links li {
            list-style: none;
            padding: 12px 20px;
            transition: all 0.3s;
        }

        .nav-links li:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--secondary);
        }

        .nav-links li.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--secondary);
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .nav-links i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .header h2 {
            color: var(--primary);
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        /* Cards Styles */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-header h3 {
            font-size: 16px;
            color: #666;
        }

        .card-header i {
            font-size: 24px;
            color: var(--primary);
        }

        .card-content {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
        }

        .card-footer {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        /* Dashboard Sections */
        .dashboard-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .section-header h3 {
            color: var(--primary);
            font-weight: 600;
        }

        .btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: 500;
        }

        .btn:hover {
            background: #1a5a8a;
        }

        /* Calendar Styles */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-header {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .calendar-day {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            cursor: pointer;
        }

        .calendar-day:hover {
            background: #f0f0f0;
        }

        .calendar-day.active {
            background: var(--primary);
            color: white;
        }

        .calendar-day.has-appointment {
            position: relative;
        }

        .calendar-day.has-appointment::after {
            content: "";
            position: absolute;
            bottom: 5px;
            width: 6px;
            height: 6px;
            background: var(--secondary);
            border-radius: 50%;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #f5f7fa;
            color: var(--primary);
            font-weight: 600;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status.scheduled {
            background: #e3f2fd;
            color: var(--primary);
        }

        .status.completed {
            background: #e8f5e9;
            color: var(--success);
        }

        .status.cancelled {
            background: #ffebee;
            color: var(--danger);
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
            }

            .nav-links {
                display: flex;
                overflow-x: auto;
            }

            .nav-links li {
                border-left: none;
                border-bottom: 4px solid transparent;
            }

            .nav-links li:hover,
            .nav-links li.active {
                border-left: none;
                border-bottom: 4px solid var(--secondary);
            }
        }

        @media (max-width: 768px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .calendar {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-clinic-medical"></i>
                <h1>Klinik Sehat Bahagia</h1>
            </div>
            <ul class="nav-links">
                <li class="active"><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-syringe"></i> Vaksinasi</a></li>
                <li><a href="#"><i class="fas fa-calendar-check"></i> Booking</a></li>
                <li><a href="#"><i class="fas fa-history"></i> Riwayat</a></li>
                <li><a href="#"><i class="fas fa-user"></i> Profil</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h2>Dashboard Pasien</h2>
                <div class="user-info">
                    <img src="https://i.pravatar.cc/150?img=32" alt="User Avatar">
                    <span>Budi Santoso</span>
                </div>
            </div>

            <!-- Cards Section -->
            <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <h3>Vaksinasi Mendatang</h3>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="card-content">2</div>
                    <div class="card-footer">Janji dalam 7 hari ke depan</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Vaksinasi Selesai</h3>
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-content">5</div>
                    <div class="card-footer">Total vaksinasi yang telah dilakukan</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Vaksinasi Tertunda</h3>
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="card-content">1</div>
                    <div class="card-footer">Perlu penjadwalan ulang</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Vaksin Tersedia</h3>
                        <i class="fas fa-syringe"></i>
                    </div>
                    <div class="card-content">8</div>
                    <div class="card-footer">Jenis vaksin yang tersedia</div>
                </div>
            </div>

            <!-- Jadwal Vaksinasi Section -->
            <div class="dashboard-section">
                <div class="section-header">
                    <h3>Jadwal Vaksinasi</h3>
                    <button class="btn">Lihat Semua</button>
                </div>

                <div class="calendar-header">
                    <div>Minggu</div>
                    <div>Senin</div>
                    <div>Selasa</div>
                    <div>Rabu</div>
                    <div>Kamis</div>
                    <div>Jumat</div>
                    <div>Sabtu</div>
                </div>

                <div class="calendar">
                    <!-- Calendar days will be populated by JavaScript -->
                </div>

                <div style="margin-top: 20px;">
                    <h4 style="margin-bottom: 10px;">Janji Mendatang</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Jenis Vaksin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>15 Oktober 2023</td>
                                <td>10:00 WIB</td>
                                <td>Influenza</td>
                                <td><span class="status scheduled">Terjadwal</span></td>
                            </tr>
                            <tr>
                                <td>22 Oktober 2023</td>
                                <td>14:30 WIB</td>
                                <td>COVID-19 Booster</td>
                                <td><span class="status scheduled">Terjadwal</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Booking Vaksinasi Section -->
            <div class="dashboard-section">
                <div class="section-header">
                    <h3>Booking Vaksinasi</h3>
                </div>

                <form id="bookingForm">
                    <div class="form-group">
                        <label for="vaccineType">Jenis Vaksin</label>
                        <select class="form-control" id="vaccineType" required>
                            <option value="">Pilih Jenis Vaksin</option>
                            <option value="covid">COVID-19</option>
                            <option value="influenza">Influenza</option>
                            <option value="hepatitis">Hepatitis B</option>
                            <option value="hpv">HPV</option>
                            <option value="tetanus">Tetanus</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointmentDate">Tanggal Janji</label>
                        <input type="date" class="form-control" id="appointmentDate" required>
                    </div>

                    <div class="form-group">
                        <label for="appointmentTime">Waktu Janji</label>
                        <select class="form-control" id="appointmentTime" required>
                            <option value="">Pilih Waktu</option>
                            <option value="08:00">08:00 WIB</option>
                            <option value="09:00">09:00 WIB</option>
                            <option value="10:00">10:00 WIB</option>
                            <option value="11:00">11:00 WIB</option>
                            <option value="13:00">13:00 WIB</option>
                            <option value="14:00">14:00 WIB</option>
                            <option value="15:00">15:00 WIB</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                    </div>

                    <button type="submit" class="btn">Buat Janji</button>
                </form>
            </div>

            <!-- Riwayat Vaksinasi Section -->
            <div class="dashboard-section">
                <div class="section-header">
                    <h3>Riwayat Vaksinasi</h3>
                    <button class="btn">Ekspor Riwayat</button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Vaksin</th>
                            <th>Dosis</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10 September 2023</td>
                            <td>COVID-19 Booster</td>
                            <td>Dosis 3</td>
                            <td><span class="status completed">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>25 Agustus 2023</td>
                            <td>Influenza</td>
                            <td>Dosis Tahunan</td>
                            <td><span class="status completed">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>15 Juli 2023</td>
                            <td>Hepatitis B</td>
                            <td>Dosis 2</td>
                            <td><span class="status completed">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>5 Juni 2023</td>
                            <td>Tetanus</td>
                            <td>Dosis 1</td>
                            <td><span class="status completed">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>20 Mei 2023</td>
                            <td>COVID-19</td>
                            <td>Dosis 2</td>
                            <td><span class="status completed">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Calendar generation
        document.addEventListener('DOMContentLoaded', function() {
            const calendar = document.querySelector('.calendar');
            const today = new Date();
            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();

            // Get first day of month and number of days
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const daysInMonth = lastDay.getDate();

            // Create empty cells for days before the first day of the month
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('calendar-day');
                calendar.appendChild(emptyDay);
            }

            // Create cells for each day of the month
            for (let i = 1; i <= daysInMonth; i++) {
                const day = document.createElement('div');
                day.classList.add('calendar-day');
                day.textContent = i;

                // Mark today
                if (i === today.getDate() && currentMonth === today.getMonth() && currentYear === today
                    .getFullYear()) {
                    day.classList.add('active');
                }

                // Mark days with appointments (random for demo)
                if (Math.random() > 0.7) {
                    day.classList.add('has-appointment');
                }

                calendar.appendChild(day);
            }

            // Booking form submission
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const vaccineType = document.getElementById('vaccineType').value;
                const appointmentDate = document.getElementById('appointmentDate').value;
                const appointmentTime = document.getElementById('appointmentTime').value;

                if (vaccineType && appointmentDate && appointmentTime) {
                    alert(
                        `Janji vaksinasi ${vaccineType} berhasil dibuat untuk tanggal ${appointmentDate} pukul ${appointmentTime} WIB.`);
                    document.getElementById('bookingForm').reset();
                } else {
                    alert('Harap lengkapi semua field yang diperlukan.');
                }
            });
        });
    </script>
</body>

</html>
