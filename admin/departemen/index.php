<?php
require_once "../../config/db.php";

try {
    $sql = "
        SELECT 
            d.id_departemen,
            d.nama_departemen,
            d.judul_layanan,
            d.deskripsi,
            COUNT(r.id_ruangan) AS total_ruangan,
            SUM(CASE WHEN r.status_ketersediaan != 'Tersedia' THEN 1 ELSE 0 END) AS ruangan_terpakai
        FROM tb_departemen d
        LEFT JOIN tb_ruangan r ON d.id_departemen = r.id_departemen
        GROUP BY d.id_departemen
    ";

    // Mengeksekusi query menggunakan metode PDO 
    $stmt = $conn->query($sql);
    $departemens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Menangani error sesuai standar PDO 
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departemen & Ruangan - RSUD Bakti Permana</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Variabel CSS dan Layout Utama (Sama dengan dokter.php) */
        :root {
            --bg-body: #eef2f6;
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
            background-color: var(--bg-body);
            background-image: url(../../assets/images/bg.png);
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

        .brand-logo img {
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
            background-color: rgba(0, 0, 0, 0.02);
        }

        .nav-link-custom.active {
            background-color: #ffffff;
            color: var(--primary-text);
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            background-color: var(--bg-content);
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
            padding: 2rem 2.5rem;
            overflow-y: auto;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.02);
        }

        /* Header Components */
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

        /* Card Departemen Styling */
        .dept-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.01);
            transition: all 0.2s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-container {
            position: relative;
        }

        .card-container .dropdown {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 10;
        }

        .dept-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
            transform: translateY(-3px);
        }

        .dept-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .dept-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-text);
            margin-bottom: 0.25rem;
        }

        .dept-subtitle {
            font-size: 0.8rem;
            color: var(--muted-text);
            margin-bottom: 1.2rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Tombol Tambah */
        .btn-add {
            background-color: #0f172a;
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 0.75rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-add:hover {
            background-color: #1e293b;
            color: white;
            transform: translateY(-1px);
        }

        /* Styling Tabel Ruangan (Sama seperti custom-table dokter) */
        .table-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.01);
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .custom-table th {
            color: var(--muted-text);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1rem 0.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .custom-table td {
            padding: 1rem;
            background-color: #f8fafc;
            vertical-align: middle;
            color: var(--primary-text);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .custom-table tbody tr td:first-child {
            border-top-left-radius: 0.75rem;
            border-bottom-left-radius: 0.75rem;
        }

        .custom-table tbody tr td:last-child {
            border-top-right-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
        }

        .custom-table tbody tr:hover td {
            background-color: #f1f5f9;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-tersedia {
            background-color: #dcfce7;
            color: #15803d;
        }

        .status-penuh {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-maintenance {
            background-color: #fef3c7;
            color: #b45309;
        }

        .action-btn {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 6px;
            border-radius: 0.5rem;
            color: var(--muted-text);
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
        }

        .action-btn:hover.edit {
            border-color: var(--accent-blue);
            color: var(--accent-blue);
        }

        .action-btn:hover.delete {
            border-color: var(--accent-red);
            color: var(--accent-red);
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            background: transparent;
            border: none;
            color: var(--muted-text);
            cursor: pointer;
            padding: 4px;
            border-radius: 0.25rem;
            transition: all 0.2s;
        }

        .dropdown-toggle:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: var(--primary-text);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            min-width: 120px;
            z-index: 1000;
            display: none;
            padding: 0.5rem 0;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: var(--primary-text);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: var(--primary-text);
        }

        .dropdown-item.edit:hover {
            color: var(--accent-blue);
        }

        .dropdown-item.delete:hover {
            color: var(--accent-red);
        }
    </style>
</head>

<body>

    <div class="app-container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="#" class="brand-logo">
                <img src="../../assets/images/logo.png" alt="" srcset="">
            </a>

            <nav class="mt-2">
                <a href="../dashboard.php" class="nav-link-custom">
                    <i data-lucide="layout-dashboard" size="20"></i> Dashboard
                </a>
                <a href="../janji_temu/index.php" class="nav-link-custom">
                    <i data-lucide="calendar-days" size="20"></i> Janji Temu
                </a>
                <a href="../pasien/index.php" class="nav-link-custom">
                    <i data-lucide="user" size="20"></i> Pasien
                </a>
                <a href="../dokter/index.php" class="nav-link-custom">
                    <i data-lucide="stethoscope" size="20"></i> Dokter
                </a>
                <a href="../jadwal_dokter/index.php" class="nav-link-custom">
                    <i data-lucide="clipboard-list" size="20"></i> Jadwal Dokter
                </a>
                <a href="../departemen/index.php" class="nav-link-custom active">
                    <i data-lucide="git-merge" size="20"></i> Departemen
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content relative">

            <!-- Header Row -->
            <header class="d-flex justify-content-between align-items-center mb-5">
                <div class="search-bar">
                    <i data-lucide="search" size="18" color="#94a3b8"></i>
                    <input type="text" placeholder="Cari departemen atau ruangan...">
                </div>

                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <span class="font-weight-bold text-dark" style="font-size: 0.9rem; font-weight: 600;">Admin</span>
                    <i data-lucide="chevron-down" size="16" color="#94a3b8" class="me-1"></i>
                </div>
            </header>

            <!-- ========================================== -->
            <!-- VIEW 1: DAFTAR DEPARTEMEN (GRID CARDS)     -->
            <!-- ========================================== -->
            <div id="view-departemen-list">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--primary-text);">Data Departemen</h4>
                        <span style="font-size: 0.85rem; color: var(--muted-text);">Pilih departemen untuk melihat detail dan daftar ruangan.</span>
                    </div>
                    <a href="insert.php" class="btn-add">
                        <i data-lucide="plus" size="18"></i> Tambah Departemen
                    </a>
                </div>

                <div class="row g-4">
                    <?php foreach ($departemens as $dept): ?>
                        <?php
                        $id = $dept['id_departemen'];
                        $nama = htmlspecialchars($dept['nama_departemen']);
                        $total = (int)$dept['total_ruangan'];
                        $terpakai = (int)$dept['ruangan_terpakai'];

                        // Kalkulasi persentase untuk Progress Bar
                        $persen = ($total > 0) ? ($terpakai / $total) * 100 : 0;
                        ?>

                        <div class="col-md-4">
                            <div class="card-container position-relative">
                                <!-- Dropdown Menu -->
                                <div class="dropdown">
                                    <button class="dropdown-toggle" onclick="toggleDropdown(event, 'dropdown-<?= $id ?>')">
                                        <i data-lucide="more-vertical" size="16"></i>
                                    </button>
                                    <div id="dropdown-<?= $id ?>" class="dropdown-menu">
                                        <a href="edit.php?id=<?= $id ?>" class="dropdown-item edit">
                                            <i data-lucide="pencil" size="14" class="me-2"></i> Edit
                                        </a>
                                        <a href="#" class="dropdown-item delete" onclick="confirmDelete(<?= $id ?>, '<?= htmlspecialchars($nama) ?>')">
                                            <i data-lucide="trash-2" size="14" class="me-2"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                                
                                <a href="detail.php?id=<?= $id ?>" class="card-link" style="text-decoration: none; color: inherit;">
                                    <div class="dept-card">
                                        <div class="dept-icon-wrapper bg-primary bg-opacity-10 text-primary">
                                            <i data-lucide="git-merge" size="24"></i>
                                        </div>
                                        <h5 class="dept-title"><?= $nama ?></h5>
                                        <p class="dept-subtitle"><?= htmlspecialchars($dept['deskripsi']) ?></p>

                                        <div class="mt-auto pt-3 border-top">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span style="font-size: 0.75rem; font-weight: 600; color: #94a3b8;">KAPASITAS RUANGAN</span>
                                                <span style="font-size: 0.8rem; font-weight: 700; color: #2563eb;">
                                                    <?= $terpakai ?>/<?= $total ?> Terpakai
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $persen ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- VIEW 2: DETAIL DEPARTEMEN & RUANGAN        -->
            <!-- ========================================== -->
            <div id="view-departemen-detail" class="d-none animate__animated animate__fadeIn">

                <!-- Breadcrumb / Tombol Kembali -->
                <button class="btn btn-sm btn-light border text-muted mb-4 d-inline-flex align-items-center gap-2" onclick="hideDetail()" style="border-radius: 0.5rem;">
                    <i data-lucide="arrow-left" size="16"></i> Kembali ke Daftar Departemen
                </button>

                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill" id="detail-judul-layanan">Layanan</span>
                        <h3 class="fw-bold mb-2" style="color: var(--primary-text);" id="detail-nama-dept">Nama Departemen</h3>
                        <p class="text-muted mb-0" style="max-width: 600px;" id="detail-deskripsi">Deskripsi departemen akan muncul di sini.</p>
                    </div>
                    <!-- Tombol Tambah Ruangan -->
                    <a href="#" class="btn-add">
                        <i data-lucide="plus" size="18"></i> Tambah Ruangan
                    </a>
                </div>

                <!-- Table Daftar Ruangan -->
                <div class="table-card mt-2">
                    <h6 class="fw-bold mb-4">Daftar Ruangan Terdaftar</h6>
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Nama Ruangan</th>
                                    <th class="text-center">Kapasitas Maksimal</th>
                                    <th class="text-center">Pasien Saat Ini</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Statis Contoh -->
                                <tr>
                                    <td>
                                        <span class="d-block text-dark fw-bold">Ruang Mawar 01</span>
                                        <span style="font-size: 0.75rem; color: var(--muted-text);">ID Ruangan: #R-101</span>
                                    </td>
                                    <td class="text-center">4 Bed</td>
                                    <td class="text-center"><span class="fw-bold text-primary">2</span></td>
                                    <td><span class="status-badge status-tersedia">Tersedia</span></td>
                                    <td class="text-end">
                                        <a href="#" class="action-btn edit me-1" title="Edit Ruangan"><i data-lucide="pencil" size="16"></i></a>
                                        <a href="#" class="action-btn delete" title="Hapus Ruangan"><i data-lucide="trash-2" size="16"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="d-block text-dark fw-bold">Ruang Melati VIP</span>
                                        <span style="font-size: 0.75rem; color: var(--muted-text);">ID Ruangan: #R-102</span>
                                    </td>
                                    <td class="text-center">1 Bed</td>
                                    <td class="text-center"><span class="fw-bold text-danger">1</span></td>
                                    <td><span class="status-badge status-penuh">Penuh</span></td>
                                    <td class="text-end">
                                        <a href="#" class="action-btn edit me-1" title="Edit Ruangan"><i data-lucide="pencil" size="16"></i></a>
                                        <a href="#" class="action-btn delete" title="Hapus Ruangan"><i data-lucide="trash-2" size="16"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="d-block text-dark fw-bold">Ruang Anggrek B</span>
                                        <span style="font-size: 0.75rem; color: var(--muted-text);">ID Ruangan: #R-103</span>
                                    </td>
                                    <td class="text-center">4 Bed</td>
                                    <td class="text-center"><span class="fw-bold text-dark">0</span></td>
                                    <td><span class="status-badge status-maintenance">Maintenance</span></td>
                                    <td class="text-end">
                                        <a href="#" class="action-btn edit me-1" title="Edit Ruangan"><i data-lucide="pencil" size="16"></i></a>
                                        <a href="#" class="action-btn delete" title="Hapus Ruangan"><i data-lucide="trash-2" size="16"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- Script Initialization & Logika Tampilan -->
    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();

        // Elemen DOM
        const viewList = document.getElementById('view-departemen-list');
        const viewDetail = document.getElementById('view-departemen-detail');

        const detailNama = document.getElementById('detail-nama-dept');
        const detailLayanan = document.getElementById('detail-judul-layanan');
        const detailDeskripsi = document.getElementById('detail-deskripsi');

        // Fungsi untuk menampilkan Detail Departemen
        function showDetail(nama, layanan, deskripsi) {
            // Update teks detail
            detailNama.textContent = nama;
            detailLayanan.textContent = layanan;
            detailDeskripsi.textContent = deskripsi;

            // Transisi View
            viewList.classList.add('d-none');
            viewDetail.classList.remove('d-none');

            // Animasi sederhana
            viewDetail.style.opacity = 0;
            setTimeout(() => {
                viewDetail.style.transition = 'opacity 0.3s ease';
                viewDetail.style.opacity = 1;
            }, 50);
        }

        // Fungsi untuk kembali ke Daftar Departemen
        function hideDetail() {
            viewDetail.style.opacity = 0;
            setTimeout(() => {
                viewDetail.classList.add('d-none');
                viewList.classList.remove('d-none');

                viewList.style.opacity = 0;
                setTimeout(() => {
                    viewList.style.transition = 'opacity 0.3s ease';
                    viewList.style.opacity = 1;
                }, 50);
            }, 300); // Sesuaikan dengan durasi transisi
        }

        // Fungsi untuk toggle dropdown menu
        function toggleDropdown(event, dropdownId) {
            event.preventDefault();
            event.stopPropagation();
            const dropdown = document.getElementById(dropdownId);
            const isVisible = dropdown.classList.contains('show');
            
            // Tutup semua dropdown lainnya
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
            
            // Toggle dropdown ini
            if (!isVisible) {
                dropdown.classList.add('show');
            }
        }

        // Tutup dropdown ketika klik di luar
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        // Fungsi untuk konfirmasi hapus
        function confirmDelete(id, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus departemen "' + nama + '"?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>

</html>