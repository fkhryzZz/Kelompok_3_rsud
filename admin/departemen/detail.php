<?php
// Memanggil Koneksi Database
require_once "../../config/db.php";

// Pastikan ada ID yang dikirim melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_dept = $_GET['id'];

try {
    // 1. Ambil Informasi Detail Departemen
    $stmt_dept = $conn->prepare("SELECT * FROM tb_departemen WHERE id_departemen = :id");
    $stmt_dept->bindParam(':id', $id_dept);
    $stmt_dept->execute();
    $departemen = $stmt_dept->fetch(PDO::FETCH_ASSOC);

    // Jika ID tidak ditemukan di database, tendang balik ke halaman departemen
    if (!$departemen) {
        header("Location: index.php");
        exit();
    }

    // 2. Ambil Daftar Ruangan yang berafiliasi dengan Departemen ini
    $stmt_ruangan = $conn->prepare("SELECT * FROM tb_ruangan WHERE id_departemen = :id ORDER BY nama_ruangan ASC");
    $stmt_ruangan->bindParam(':id', $id_dept);
    $stmt_ruangan->execute();
    $ruangans = $stmt_ruangan->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Terjadi Kesalahan Database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Departemen - RSUD Bakti Permana</title>

    <!-- Bootstrap 5 & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* CSS Lengkap (Sama dengan index.php agar serasi) */
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
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .app-container {
            width: 96vw;
            height: 94vh;
            background-color: var(--bg-sidebar);
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            display: flex;
            overflow: hidden;
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

        .main-content {
            flex-grow: 1;
            background-color: var(--bg-content);
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
            padding: 2rem 2.5rem;
            overflow-y: auto;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.02);
        }

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
        <main class="main-content">

            <header class="d-flex justify-content-between align-items-center mb-5">
                <div class="search-bar">
                    <i data-lucide="search" size="18" color="#94a3b8"></i>
                    <input type="text" placeholder="Cari departemen atau ruangan...">
                </div>
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <span class="font-weight-bold text-dark" style="font-size: 0.9rem;">Admin</span>
                    <i data-lucide="chevron-down" size="16" color="#94a3b8" class="me-1"></i>
                </div>
            </header>

            <!-- Tautan Kembali -->
            <a href="index.php" class="btn btn-sm btn-light border text-muted mb-4 d-inline-flex align-items-center gap-2" style="border-radius: 0.5rem; text-decoration: none;">
                <i data-lucide="arrow-left" size="16"></i> Kembali ke Daftar Departemen
            </a>

            <!-- Info Departemen -->
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill">
                        <?= htmlspecialchars($departemen['judul_layanan']) ?>
                    </span>
                    <h3 class="fw-bold mb-2" style="color: var(--primary-text);">
                        <?= htmlspecialchars($departemen['nama_departemen']) ?>
                    </h3>
                    <p class="text-muted mb-0" style="max-width: 600px;">
                        <?= nl2br(htmlspecialchars($departemen['deskripsi'])) ?>
                    </p>
                </div>
                <!-- Bawa ID departemen ke form tambah ruangan -->
                <a href="ruangan/insert_ruangan.php?id_dept=<?= $id_dept ?>" class="btn-add">
                    <i data-lucide="plus" size="18"></i> Tambah Ruangan
                </a>
            </div>

            <!-- Tabel Daftar Ruangan -->
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

                            <?php if (empty($ruangans)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i data-lucide="inbox" size="32" class="mb-2 opacity-50"></i><br>
                                        Departemen ini belum memiliki ruangan.
                                    </td>
                                </tr>
                            <?php else: ?>

                                <?php foreach ($ruangans as $ruang): ?>
                                    <?php
                                    // Logic Badge Status
                                    $badgeClass = 'status-tersedia';
                                    if ($ruang['status_ketersediaan'] === 'Penuh') {
                                        $badgeClass = 'status-penuh';
                                    } else if ($ruang['status_ketersediaan'] === 'Maintenance') {
                                        $badgeClass = 'status-maintenance';
                                    }

                                    // Styling Warna Pasien (Merah jika melebihi/sama dengan kapasitas maks)
                                    $warnaPasien = ($ruang['jumlah_pasien_saat_ini'] >= $ruang['kapasitas_maksimal']) ? 'text-danger' : 'text-primary';
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="d-block text-dark fw-bold"><?= htmlspecialchars($ruang['nama_ruangan']) ?></span>
                                            <span style="font-size: 0.75rem; color: var(--muted-text);">ID Ruangan: #R-<?= $ruang['id_ruangan'] ?></span>
                                        </td>
                                        <td class="text-center"><?= $ruang['kapasitas_maksimal'] ?> Bed</td>
                                        <td class="text-center"><span class="fw-bold <?= $warnaPasien ?>"><?= $ruang['jumlah_pasien_saat_ini'] ?></span></td>
                                        <td><span class="status-badge <?= $badgeClass ?>"><?= htmlspecialchars($ruang['status_ketersediaan']) ?></span></td>
                                        <td class="text-end">
                                            <a href="ruangan/edit_ruangan.php?id=<?= $ruang['id_ruangan'] ?>" class="action-btn edit me-1" title="Edit Ruangan"><i data-lucide="pencil" size="16"></i></a>
                                            <a href="ruangan/delete_ruangan.php?id=<?= $ruang['id_ruangan'] ?>" class="action-btn delete" title="Hapus Ruangan" onclick="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')"><i data-lucide="trash-2" size="16"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Script Initialization -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>