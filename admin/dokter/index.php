<?php
// Memanggil koneksi database
// Sesuaikan path db.php dengan struktur folder Anda, misalnya "../db.php" jika file ini di dalam folder 'dokter'
require_once "../../config/db.php"; 

$dokters = [];

try {
    // Query untuk mengambil data dokter beserta nama departemennya (menggunakan LEFT JOIN)
    // Menambahkan relasi ke tb_users untuk mengambil data email login
    $sql = "SELECT d.*, dep.nama_departemen, u.email 
            FROM tb_dokter d 
            LEFT JOIN tb_departemen dep ON d.id_departemen = dep.id_departemen
            LEFT JOIN tb_users u ON d.id_user = u.id_user
            ORDER BY d.id_dokter DESC";
            
    $stmt = $conn->query($sql);
    $dokters = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Terjadi kesalahan database: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter - RSUD Bakti Permana</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Menggunakan ulang variabel dan layout dari dashboard utama */
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

        /* Sidebar */
        .sidebar { width: 260px; display: flex; align-items: center; flex-direction: column; padding: 2rem; border-right: 1px solid var(--border-color); }
        .brand-logo { width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 1rem; color: #0f172a; font-weight: 800; font-size: 1.25rem; line-height: 1.2; margin-bottom: 2.5rem; text-decoration: none; }
        .nav-link-custom { width: 100%; display: flex; align-items: center; gap: 12px; padding: 0.8rem 1.2rem; color: var(--muted-text); font-weight: 500; border-radius: 0.75rem; margin-bottom: 0.5rem; text-decoration: none; transition: all 0.2s ease; }
        .nav-link-custom:hover { color: var(--primary-text); background-color: rgba(0,0,0,0.02); }
        .nav-link-custom.active { background-color: #ffffff; color: var(--primary-text); font-weight: 600; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04); }

        /* Main Content */
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
        .search-bar { background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: 2rem; padding: 0.5rem 1rem; display: flex; align-items: center; width: 350px; }
        .search-bar input { border: none; background: transparent; outline: none; width: 100%; margin-left: 10px; color: var(--primary-text); font-size: 0.9rem; }
        .user-profile { display: flex; align-items: center; gap: 10px; background-color: #f8fafc; border: 1px solid var(--border-color); padding: 0.4rem 0.8rem 0.4rem 0.4rem; border-radius: 2rem; cursor: pointer; }
        .user-avatar { width: 32px; height: 32px; background-color: #1e293b; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; }

        /* Table Card Styling */
        .table-card { background: #ffffff; border: 1px solid var(--border-color); border-radius: 1rem; padding: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.01); }

        /* Tombol Tambah */
        .btn-add { background-color: #0f172a; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s ease; }
        .btn-add:hover { background-color: #1e293b; color: white; transform: translateY(-1px); }

        /* Styling Tabel Custom */
        .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .custom-table th { color: var(--muted-text); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 0 1rem 0.5rem 1rem; border-bottom: 1px solid var(--border-color); }
        .custom-table td { padding: 1rem; background-color: #f8fafc; vertical-align: middle; color: var(--primary-text); font-size: 0.9rem; font-weight: 500; }
        .custom-table tbody tr td:first-child { border-top-left-radius: 0.75rem; border-bottom-left-radius: 0.75rem; }
        .custom-table tbody tr td:last-child { border-top-right-radius: 0.75rem; border-bottom-right-radius: 0.75rem; }
        .custom-table tbody tr:hover td { background-color: #f1f5f9; }

        /* Action Buttons di dalam tabel */
        .action-btn { background: white; border: 1px solid #e2e8f0; padding: 6px; border-radius: 0.5rem; color: var(--muted-text); transition: all 0.2s; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .action-btn:hover.edit { border-color: var(--accent-blue); color: var(--accent-blue); }
        .action-btn:hover.delete { border-color: var(--accent-red); color: var(--accent-red); }

        .departemen-badge { background-color: #e0e7ff; color: #4338ca; padding: 0.3rem 0.8rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 600; }

    </style>
</head>
<body>

    <div class="app-container">
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="#" class="brand-logo">
                <i data-lucide="cross" fill="#2563eb" color="#2563eb" size="32"></i>
                <div>RSUD<span class="sub-brand" style="font-size: 0.7rem; font-weight: 500; color: var(--muted-text); display: block;">BAKTI PERMANA</span></div>
            </a>
            <nav class="mt-2 w-100">
                <a href="../dashboard.php" class="nav-link-custom"><i data-lucide="layout-dashboard" size="20"></i> Dashboard</a>
                <a href="../janji_temu/index.php" class="nav-link-custom"><i data-lucide="calendar-days" size="20"></i> Janji Temu</a>
                <a href="../pasien/index.php" class="nav-link-custom"><i data-lucide="user" size="20"></i> Pasien</a>
                <a href="index.php" class="nav-link-custom active"><i data-lucide="stethoscope" size="20"></i> Dokter</a>
                <a href="../jadwal_dokter/index.php" class="nav-link-custom"><i data-lucide="clipboard-list" size="20"></i> Jadwal Dokter</a>
                <a href="../departemen/index.php" class="nav-link-custom"><i data-lucide="git-merge" size="20"></i> Departemen</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            
            <!-- Header Row -->
            <header class="d-flex justify-content-between align-items-center mb-5">
                <div class="search-bar">
                    <i data-lucide="search" size="18" color="#94a3b8"></i>
                    <input type="text" placeholder="Cari nama dokter atau spesialis...">
                </div>
                
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <span class="font-weight-bold text-dark" style="font-size: 0.9rem; font-weight: 600;">Admin</span>
                    <i data-lucide="chevron-down" size="16" color="#94a3b8" class="me-1"></i>
                </div>
            </header>

            <!-- Page Title & Add Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1" style="color: var(--primary-text);">Data Dokter</h4>
                    <span style="font-size: 0.85rem; color: var(--muted-text);">Kelola daftar dokter yang terdaftar di sistem.</span>
                </div>
                <!-- Tombol diarahkan ke form_create_dokter.php -->
                <a href="insert.php" class="btn-add">
                    <i data-lucide="plus" size="18"></i> Tambah Dokter
                </a>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Profil Dokter</th>
                                <th>No. STR</th>
                                <th>Spesialisasi</th>
                                <th>Departemen</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php if (empty($dokters)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i data-lucide="folder-open" size="32" class="mb-2 opacity-50"></i><br>
                                        Belum ada data dokter yang terdaftar.
                                    </td>
                                </tr>
                            <?php else: ?>
                                
                                <?php $no = 1; foreach ($dokters as $dokter): ?>
                                    
                                    <?php
                                        // Logika untuk membuat Inisial Avatar (Mengambil huruf pertama nama setelah kata "Dr")
                                        // Menambahkan fallback (?? '') agar tidak error saat nilai nama_dokter kosong
                                        $nama_bersih = str_replace(['Dr.', 'dr.', 'Dr ', 'dr '], '', $dokter['nama_dokter'] ?? 'Tanpa Nama');
                                        $inisial = strtoupper(substr(trim($nama_bersih), 0, 1));
                                        
                                        // Logika untuk mewarnai avatar secara acak berdasarkan ID
                                        $warna_avatar = ['bg-primary', 'bg-success', 'bg-danger', 'bg-warning text-dark', 'bg-info text-dark'];
                                        $warna_terpilih = $warna_avatar[($dokter['id_dokter'] ?? 0) % count($warna_avatar)];
                                    ?>
                                    
                                    <tr>
                                        <td style="width: 50px;" class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- Avatar Bulat -->
                                                <div class="<?= $warna_terpilih ?> rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-weight: bold; color: white;">
                                                    <?= $inisial ?>
                                                </div>
                                                <div>
                                                    <span class="d-block text-dark fw-bold"><?= htmlspecialchars($dokter['nama_dokter'] ?? 'Tanpa Nama') ?></span>
                                                    <!-- Perbaikan: Menambahkan ?? '-' agar jika email dipindah ke tb_users tidak error -->
                                                    <span style="font-size: 0.75rem; color: var(--muted-text);"><?= htmlspecialchars($dokter['email'] ?? 'Email tidak tersedia') ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($dokter['no_str'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($dokter['spesialisasi'] ?? '-') ?></td>
                                        <td>
                                            <?php if (!empty($dokter['nama_departemen'])): ?>
                                                <span class="departemen-badge"><?= htmlspecialchars($dokter['nama_departemen']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border">- Belum Ada Poli -</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="form_update_dokter.php?id=<?= htmlspecialchars($dokter['id_dokter'] ?? '') ?>" class="action-btn edit me-1" title="Edit">
                                                <i data-lucide="pencil" size="16"></i>
                                            </a>
                                            <a href="delete_dokter.php?id=<?= htmlspecialchars($dokter['id_dokter'] ?? '') ?>" class="action-btn delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= htmlspecialchars($dokter['nama_dokter'] ?? '') ?>?')">
                                                <i data-lucide="trash-2" size="16"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <span style="font-size: 0.8rem; color: var(--muted-text);">
                        Total Data: <strong><?= count($dokters) ?> Dokter</strong>
                    </span>
                </div>

            </div>

        </main>
    </div>

    <!-- Script Initialization -->
    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>