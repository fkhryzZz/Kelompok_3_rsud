<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - RSUD Bakti Permana</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* CSS Native & Custom Variables */
        :root {
            --bg-body: #eef2f6; /* Warna background luar */
            --bg-sidebar: #f8f9fa;
            --bg-content: #ffffff;
            --primary-text: #1e293b;
            --muted-text: #94a3b8;
            --accent-blue: #2563eb;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --border-color: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* App Wrapper (Floating Window Style) */
        .app-container {
            width: 96vw;
            height: 94vh;
            background-image: url(../assets/images/bg.png);
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            display: flex;
            overflow: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-image: url(../assets/images/bg.png);
            display: flex;
            align-items: center;
            flex-direction: column;
            padding: 2rem;
        }

        .brand-logo {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 1rem;
            color: #0f172a;
            font-weight: 800;
            font-size: 1.25rem;
            line-height: 1.2;
            margin-bottom: 2.5rem;
            text-decoration: none;
        }
        .brand-logo img{
            width: 100%;
        }


        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1.2rem;
            color: var(--muted-text);
            font-weight: 500;
            border-radius: 0.75rem;
            margin-bottom: 0.5rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-link-custom:hover {
            color: var(--primary-text);
            background-color: rgba(0,0,0,0.02);
        }

        .nav-link-custom.active {
            background-color: #ffffff;
            color: var(--primary-text);
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        }

        /* Main Content Styling */
        .main-content {
            flex-grow: 1;
            background-color: var(--bg-content);
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
            padding: 2rem 2.5rem;
            overflow-y: auto;
            box-shadow: -5px 0 15px rgba(0,0,0,0.02);
        }

        /* Header */
        .search-bar {
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            width: 350px;
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            margin-left: 10px;
            color: var(--primary-text);
            font-size: 0.9rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            padding: 0.4rem 0.8rem 0.4rem 0.4rem;
            border-radius: 2rem;
            cursor: pointer;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background-color: #1e293b;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Cards */
        .custom-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.01);
            height: 100%;
        }

        .stat-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--muted-text);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-text);
            margin: 0.5rem 0;
        }

        .stat-growth {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent-green);
        }

        .stat-subtext {
            font-size: 0.75rem;
            color: var(--muted-text);
        }

        /* Toggle Button (Mingguan/Harian) */
        .toggle-group {
            background-color: #f1f5f9;
            border-radius: 2rem;
            padding: 0.25rem;
            display: inline-flex;
        }
        .toggle-btn {
            border: none;
            background: transparent;
            padding: 0.4rem 1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted-text);
            transition: all 0.2s;
        }
        .toggle-btn.active {
            background-color: #0f172a;
            color: white;
        }

        /* Calendar Styling */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            gap: 10px 5px;
        }
        .calendar-day-name {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--muted-text);
            margin-bottom: 0.5rem;
        }
        .calendar-date {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-text);
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            border-radius: 50%;
            cursor: pointer;
        }
        .calendar-date.text-red { color: var(--accent-red); }
        .calendar-date.active {
            background-color: #0f172a;
            color: white;
        }

        /* Agenda Item */
        .agenda-item {
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1rem;
            margin-top: 2rem;
        }

    </style>
</head>
<body>

    <div class="app-container">
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="#" class="brand-logo">
                <img src="../assets/images/logo.png" alt="" srcset="">
            </a>

            <nav class="mt-2">
                <a href="dashboard.php" class="nav-link-custom active">
                    <i data-lucide="layout-dashboard" size="20"></i> Dashboard
                </a>
                <a href="janji_temu/index.php" class="nav-link-custom">
                    <i data-lucide="calendar-days" size="20"></i> Janji Temu
                </a>
                <a href="pasien/index.php" class="nav-link-custom">
                    <i data-lucide="user" size="20"></i> Pasien
                </a>
                <a href="dokter/index.php" class="nav-link-custom">
                    <i data-lucide="stethoscope" size="20"></i> Dokter
                </a>
                <a href="jadwal_dokter/index.php" class="nav-link-custom">
                    <i data-lucide="clipboard-list" size="20"></i> Jadwal Dokter
                </a>
                <a href="departemen/index.php" class="nav-link-custom">
                    <i data-lucide="git-merge" size="20"></i> Departemen
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            
            <!-- Header Row -->
            <header class="d-flex justify-content-between align-items-center mb-5">
                <div class="search-bar">
                    <i data-lucide="search" size="18" color="#94a3b8"></i>
                    <input type="text" placeholder="Pencarian">
                </div>
                
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <span class="font-weight-bold text-dark" style="font-size: 0.9rem; font-weight: 600;">Admin</span>
                    <i data-lucide="chevron-down" size="16" color="#94a3b8" class="me-1"></i>
                </div>
            </header>

            <!-- Cards Row -->
            <div class="row g-4 mb-4">
                <!-- Card 1: Total Pasien -->
                <div class="col-md-4">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="stat-title">TOTAL PASIEN</span>
                            <span class="stat-growth">+1.3%</span>
                        </div>
                        <div class="stat-value">1,248</div>
                        <div class="stat-subtext">Lebih banyak 14 orang dari bulan lalu</div>
                    </div>
                </div>

                <!-- Card 2: Total Dokter -->
                <div class="col-md-4">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="stat-title">TOTAL DOKTER</span>
                            <span class="text-muted"><i data-lucide="stethoscope" size="18"></i></span>
                        </div>
                        <div class="stat-value">45</div>
                        <div class="stat-subtext">Tersebar di 8 departemen</div>
                    </div>
                </div>

                <!-- Card 3: Kamar -->
                <div class="col-md-4">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="stat-title">RUANGAN TERSEDIA</span>
                            <span class="text-muted"><i data-lucide="bed-double" size="18"></i></span>
                        </div>
                        <div class="stat-value">12 / 50</div>
                        <div class="stat-subtext">Kapasitas ruangan saat ini aman</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Chart & Calendar -->
            <div class="row g-4">
                
                <!-- Chart Area -->
                <div class="col-xl-8">
                    <div class="custom-card d-flex flex-column">
                        <!-- Chart Header -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <span class="stat-title">GRAFIK PASIEN BARU</span>
                                <div class="d-flex align-items-baseline gap-2 mt-1">
                                    <h3 class="fw-bold mb-0" style="color: var(--primary-text);">1,248</h3>
                                    <span class="stat-growth" style="font-size: 0.7rem;">PASIEN TAHUN INI</span>
                                </div>
                            </div>
                            <div class="toggle-group">
                                <button class="toggle-btn">Tahun Lalu</button>
                                <button class="toggle-btn active">Tahun Ini</button>
                            </div>
                        </div>

                        <!-- Chart Canvas -->
                        <div class="position-relative w-100 flex-grow-1" style="min-height: 250px;">
                            <canvas id="pasienChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Calendar Area -->
                <div class="col-xl-4">
                    <div class="custom-card">
                        <!-- Calendar Widget -->
                        <div class="calendar-header">
                            <i data-lucide="chevron-left" size="18" class="text-muted" style="cursor: pointer;"></i>
                            <span>Februari 2026</span>
                            <i data-lucide="chevron-right" size="18" class="text-muted" style="cursor: pointer;"></i>
                        </div>
                        
                        <div class="calendar-grid">
                            <!-- Days -->
                            <div class="calendar-day-name">MIN</div>
                            <div class="calendar-day-name">SEN</div>
                            <div class="calendar-day-name">SEL</div>
                            <div class="calendar-day-name">RABU</div>
                            <div class="calendar-day-name">KAM</div>
                            <div class="calendar-day-name">JUM</div>
                            <div class="calendar-day-name">SAB</div>
                            
                            <!-- Dates (Mockup) -->
                            <div class="calendar-date text-red">1</div>
                            <div class="calendar-date">2</div>
                            <div class="calendar-date">3</div>
                            <div class="calendar-date">4</div>
                            <div class="calendar-date">5</div>
                            <div class="calendar-date">6</div>
                            <div class="calendar-date">7</div>
                            
                            <div class="calendar-date text-red">8</div>
                            <div class="calendar-date">9</div>
                            <div class="calendar-date">10</div>
                            <div class="calendar-date">11</div>
                            <div class="calendar-date">12</div>
                            <div class="calendar-date">13</div>
                            <div class="calendar-date">14</div>
                            
                            <div class="calendar-date text-red">15</div>
                            <div class="calendar-date">16</div>
                            <div class="calendar-date">17</div>
                            <div class="calendar-date">18</div>
                            <div class="calendar-date active">19</div>
                            <div class="calendar-date">20</div>
                            <div class="calendar-date">21</div>
                            
                            <div class="calendar-date text-red">22</div>
                            <div class="calendar-date">23</div>
                            <div class="calendar-date">24</div>
                            <div class="calendar-date">25</div>
                            <div class="calendar-date">26</div>
                            <div class="calendar-date">27</div>
                            <div class="calendar-date">28</div>
                            
                            <div class="calendar-date text-red">29</div>
                            <div class="calendar-date">30</div>
                            <div class="calendar-date">31</div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>

                        <!-- Mini Agenda Widget -->
                        <div class="agenda-item">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold" style="font-size: 0.85rem;">Kamis, 19 Februari</span>
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center cursor-pointer" style="width: 24px; height: 24px;">
                                    <i data-lucide="plus" size="14"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i data-lucide="user" size="16" class="text-muted"></i>
                                </div>
                                <span class="fw-semibold text-dark" style="font-size: 0.85rem;">Dr. Sarah</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            
            <!-- Footer Watermark -->
            <div class="text-center mt-4">
                <small class="text-muted" style="font-size: 0.7rem;">©Copyright by Kelompok 7. All rights reserved.</small>
            </div>

        </main>
    </div>

    <!-- Script Initialization -->
    <script>
        // 1. Inisialisasi Lucide Icons
        lucide.createIcons();

        // 2. Setup Chart.js (Grafik Pasien)
        const ctx = document.getElementById('pasienChart').getContext('2d');
        
        // Buat efek gradasi warna biru di bawah garis
        let gradientBlue = ctx.createLinearGradient(0, 0, 0, 300);
        gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.25)'); // Biru transparan atas
        gradientBlue.addColorStop(1, 'rgba(37, 99, 235, 0)');    // Hilang di bawah

        // Data dummy Pasien per bulan
        const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const dataPasien = [65, 78, 90, 105, 120, 115, 134, 150, 145, 160, 175, 190];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: bulanLabels,
                datasets: [
                    {
                        label: 'Jumlah Pasien Baru',
                        data: dataPasien,
                        borderColor: '#2563eb', // Biru
                        backgroundColor: gradientBlue,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4, // Membuat kurva bergelombang halus
                        pointRadius: 0, // Sembunyikan titik kecuali dihover
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#2563eb',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend default bawaan chart
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' Orang';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        ticks: {
                            stepSize: 50,
                            color: '#94a3b8',
                            font: { size: 10 }
                        },
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 10, weight: 'bold' }
                        },
                        grid: {
                            display: false, // Hilangkan garis vertikal
                            drawBorder: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>