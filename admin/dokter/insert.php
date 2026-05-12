<?php
// Memanggil koneksi database
require_once "../../config/db.php";

$departemens = [];

try {
    // Mengambil daftar departemen untuk dropdown select poli/departemen
    $stmt = $conn->query("SELECT id_departemen, nama_departemen FROM tb_departemen ORDER BY nama_departemen ASC");
    $departemens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dokter - RSUD Bakti Permana</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Variabel CSS dan Layout Utama */
        :root {
            --bg-body: #eef2f6; --bg-sidebar: #f8f9fa; --bg-content: #ffffff;
            --primary-text: #1e293b; --muted-text: #94a3b8;
            --accent-blue: #2563eb; --accent-green: #10b981; --accent-red: #ef4444;
            --border-color: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif; background-color: var(--bg-body);
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px;
            height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center;
        }

        .app-container { width: 96vw; height: 94vh; background-color: var(--bg-sidebar); border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08); display: flex; overflow: hidden; }

        .sidebar { width: 260px; display: flex; align-items: center; flex-direction: column; padding: 2rem; border-right: 1px solid var(--border-color); }
        .brand-logo { width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 1rem; color: #0f172a; font-weight: 800; font-size: 1.25rem; line-height: 1.2; margin-bottom: 2.5rem; text-decoration: none; }
        .nav-link-custom { width: 100%; display: flex; align-items: center; gap: 12px; padding: 0.8rem 1.2rem; color: var(--muted-text); font-weight: 500; border-radius: 0.75rem; margin-bottom: 0.5rem; text-decoration: none; transition: all 0.2s ease; }
        .nav-link-custom:hover { color: var(--primary-text); background-color: rgba(0,0,0,0.02); }
        .nav-link-custom.active { background-color: #ffffff; color: var(--primary-text); font-weight: 600; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04); }

        .main-content { flex-grow: 1; background-color: var(--bg-content); border-top-left-radius: 1.5rem; border-bottom-left-radius: 1.5rem; padding: 2rem 2.5rem; overflow-y: auto; box-shadow: -5px 0 15px rgba(0,0,0,0.02); }
        .search-bar { background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: 2rem; padding: 0.5rem 1rem; display: flex; align-items: center; width: 350px; }
        .search-bar input { border: none; background: transparent; outline: none; width: 100%; margin-left: 10px; color: var(--primary-text); font-size: 0.9rem; }
        .user-profile { display: flex; align-items: center; gap: 10px; background-color: #f8fafc; border: 1px solid var(--border-color); padding: 0.4rem 0.8rem 0.4rem 0.4rem; border-radius: 2rem; cursor: pointer; }
        .user-avatar { width: 32px; height: 32px; background-color: #1e293b; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; }

        /* Form Layout & Card */
        .form-card { background: #ffffff; border: 1px solid var(--border-color); border-radius: 1rem; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.01); max-width: 900px; }
        .custom-label { font-size: 0.85rem; font-weight: 600; color: var(--primary-text); margin-bottom: 0.5rem; display: block; }
        .form-control-custom { border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.8rem 1rem; font-size: 0.9rem; color: var(--primary-text); background-color: #f8fafc; transition: all 0.2s ease; width: 100%; display: block; }
        .form-control-custom:focus { outline: none; border-color: var(--accent-blue); background-color: #ffffff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        
        .section-title { font-size: 0.95rem; font-weight: 700; color: var(--primary-text); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color); }
        
        .btn-submit { background-color: var(--accent-blue); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-size: 0.9rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; text-decoration: none; cursor: pointer; }
        .btn-submit:hover { background-color: #1d4ed8; color: white; transform: translateY(-1px); }
        .btn-cancel { background-color: transparent; color: var(--muted-text); border: 1px solid #e2e8f0; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-size: 0.9rem; font-weight: 600; transition: all 0.2s ease; text-decoration: none; }
        .btn-cancel:hover { background-color: #f1f5f9; color: var(--primary-text); }
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
                <a href="dokter.php" class="nav-link-custom active"><i data-lucide="stethoscope" size="20"></i> Dokter</a>
                <a href="../jadwal_dokter/index.php" class="nav-link-custom"><i data-lucide="clipboard-list" size="20"></i> Jadwal Dokter</a>
                <a href="../departemen/index.php" class="nav-link-custom"><i data-lucide="git-merge" size="20"></i> Departemen</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content position-relative">
            
            <header class="d-flex justify-content-between align-items-center mb-5">
                <div class="search-bar">
                    <i data-lucide="search" size="18" color="#94a3b8"></i>
                    <input type="text" placeholder="Pencarian...">
                </div>
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <span class="font-weight-bold text-dark" style="font-size: 0.9rem; font-weight: 600;">Admin</span>
                    <i data-lucide="chevron-down" size="16" color="#94a3b8" class="me-1"></i>
                </div>
            </header>

            <a href="index.php" class="btn btn-sm btn-light border text-muted mb-4 d-inline-flex align-items-center gap-2" style="border-radius: 0.5rem; text-decoration: none;">
                <i data-lucide="arrow-left" size="16"></i> Kembali ke Data Dokter
            </a>

            <!-- Judul Halaman -->
            <div class="mb-4">
                <h4 class="fw-bold mb-1" style="color: var(--primary-text);">Tambah Dokter Baru</h4>
                <span style="font-size: 0.85rem; color: var(--muted-text);">Isi formulir di bawah ini untuk menambahkan dokter beserta akun loginnya ke dalam sistem.</span>
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <form action="insert_proses.php" method="POST">
                    <div class="row g-4">
                        
                        <!-- SEKSI: DATA AKUN LOGIN -->
                        <div class="col-12">
                            <h5 class="section-title"><i data-lucide="shield-check" size="18" class="me-2 text-primary"></i>Kredensial Akun</h5>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="custom-label">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control-custom" placeholder="Misal: dokter@rsud.com" required>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="custom-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                        </div>


                        <!-- SEKSI: PROFIL DOKTER -->
                        <div class="col-12 mt-4">
                            <h5 class="section-title"><i data-lucide="user" size="18" class="me-2 text-primary"></i>Profil Dokter</h5>
                        </div>

                        <!-- Nama Dokter -->
                        <div class="col-md-12 mt-3">
                            <label class="custom-label">Nama Lengkap Dokter (beserta gelar) <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dokter" class="form-control-custom" placeholder="Misal: Dr. Budi Santoso, Sp.A" required>
                        </div>

                        <!-- No STR -->
                        <div class="col-md-6">
                            <label class="custom-label">Nomor STR <span class="text-danger">*</span></label>
                            <input type="number" name="no_str" class="form-control-custom" placeholder="Masukkan 16 digit Nomor STR" required>
                        </div>

                        <!-- Spesialisasi -->
                        <div class="col-md-6">
                            <label class="custom-label">Spesialisasi <span class="text-danger">*</span></label>
                            <input type="text" name="spesialisasi" class="form-control-custom" placeholder="Misal: Penyakit Dalam / Pediatrik" required>
                        </div>

                        <!-- Pilihan Departemen -->
                        <div class="col-md-12">
                            <label class="custom-label">Penempatan Departemen/Poli <span class="text-danger">*</span></label>
                            <select name="id_departemen" class="form-control-custom" style="appearance: auto;" required>
                                <option value="" disabled selected>-- Pilih Departemen --</option>
                                <?php foreach($departemens as $dept): ?>
                                    <option value="<?= $dept['id_departemen'] ?>">
                                        <?= htmlspecialchars($dept['nama_departemen']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 mt-5 d-flex gap-3">
                            <button type="submit" class="btn-submit">
                                <i data-lucide="save" size="18"></i> Simpan Data Dokter
                            </button>
                            <a href="index.php" class="btn-cancel">Batal</a>
                        </div>

                    </div>
                </form>
            </div>

        </main>
    </div>

    <!-- Script Initialization -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>