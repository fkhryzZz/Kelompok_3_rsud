<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - RSUD Bakti Permana</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --primary-blue: #1e3a8a;
            /* Blue 900 */
            --accent-cyan: #22d3ee;
            /* Cyan 400 */
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-800: #1e293b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: url(../assets/images/bg.png);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            margin: 0;
        }

        .register-card {
            background-color: white;
            width: 100%;
            max-width: 1100px;
            height: fit-content;
            border-radius: 50px;
            box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.05);
            display: flex;
            overflow: hidden;
            border: 1px solid var(--slate-100);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Sidebar Style */
        .sidebar-info {
            background-color: var(--primary-blue);
            position: relative;
            padding: 3rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            z-index: 1;
        }

        .sidebar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.3;
            mix-blend-mode: overlay;
            object-fit: cover;
            z-index: -1;
        }

        .sidebar-circle {
            position: absolute;
            bottom: -5rem;
            right: -5rem;
            width: 20rem;
            height: 20rem;
            background-color: #1e40af;
            /* Blue 800 */
            border-radius: 50%;
            z-index: -1;
        }

        /* Form Style */
        .form-container {
            padding: 3rem;
            overflow-y: auto;
        }

        /* Custom Scrollbar */
        .form-container::-webkit-scrollbar {
            width: 4px;
        }

        .form-container::-webkit-scrollbar-thumb {
            background: var(--slate-100);
            border-radius: 10px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 0.5rem;
        }

        .input-group-custom .icon-input {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-300);
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            padding: 1rem 1rem 1rem 3.5rem;
            background-color: var(--slate-50);
            border: 2px solid transparent;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            outline: none;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            background-color: white;
            border-color: #dbeafe;
            /* Blue 100 */
            box-shadow: 0 0 0 4px rgba(219, 234, 254, 0.5);
        }

        label.custom-label {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--slate-400);
            margin-bottom: 0.5rem;
            margin-left: 0.25rem;
            display: block;
        }

        .btn-register {
            width: 100%;
            padding: 1.25rem;
            background-color: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(30, 58, 138, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-register:hover {
            background-color: var(--slate-800);
            transform: translateY(-2px);
        }

        .btn-register:active {
            transform: scale(0.98);
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .feature-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .copyright-text {
            font-size: 10px;
            font-weight: 700;
            color: #93c5fd;
            /* Blue 300 */
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        /* Responsive Fixes */
        @media (max-width: 991.98px) {
            .register-card {
                height: auto;
                max-height: 90vh;
            }

            .sidebar-info {
                display: none !important;
            }

            .form-container {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

    <div class="register-card">
        <div class="row g-0 w-100 h-100">
            <!-- Left Panel (Info) - Visible on Large Screens -->
            <div class="col-lg-5 sidebar-info d-none d-lg-flex">
                <!-- Mock Background Image -->
                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=1000" alt="Hospital background" class="sidebar-overlay">

                <img src="../assets/images/logo-white.png" alt="RSUD BP" style="width: 180px;">
                <div>
                    <h2 class="display-6 fw-bolder mb-3">Gabung dalam<br>Ekosistem Digital Kami.</h2>
                    <p class="text-white-50 small fw-medium leading-relaxed">
                        Lihat riwayat perawatan, diskon, dan benefit menarik yang menunggu.
                    </p>
                </div>

                <div class="features-list z-3">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i data-lucide="check" style="width: 1rem; height: 1rem; color: var(--accent-cyan);"></i>
                        </div>
                        <span class="small fw-bold text-uppercase tracking-wider">Riwayat Perawatan </span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i data-lucide="check" style="width: 1rem; height: 1rem; color: var(--accent-cyan);"></i>
                        </div>
                        <span class="small fw-bold text-uppercase tracking-wider">Diskon Pengguna</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i data-lucide="check" style="width: 1rem; height: 1rem; color: var(--accent-cyan);"></i>
                        </div>
                        <span class="small fw-bold text-uppercase tracking-wider">Info Terkini</span>
                    </div>
                </div>


                <div class="sidebar-circle"></div>
            </div>

            <!-- Right Panel (Form) -->
            <div class="col-lg-7 form-container d-flex flex-column justify-content-center">
                <div class="mb-5">
                    <h1 class="h2 fw-bolder text-dark mb-1">Buat Akun Baru</h1>
                    <p class="text-muted fw-medium">Lengkapi data untuk mendaftar</p>
                </div>

                <form action="insert.php" method="POST">
                    <div class="row g-4">
                        <!-- Nama Lengkap -->
                        <div class="col-12">
                            <label class="custom-label">Nama Lengkap</label>
                            <div class="input-group-custom">
                                <i data-lucide="user" size="20" class="icon-input"></i>
                                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" class="form-control-custom" required>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6">
                            <label class="custom-label">Jenis Kelamin</label>
                            <div class="input-group-custom">
                                <i data-lucide="venus-and-mars" size="20" class="icon-input"></i>
                                <select name="jenis_kelamin" class="form-control-custom" style="appearance: none;" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="LAKI-LAKI">Laki-laki</option>
                                    <option value="PEREMPUAN">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <!-- tgl Lahir -->
                        <div class="col-md-6">
                            <label class="custom-label">Tanggal Lahir</label>
                            <div class="input-group-custom">
                                <i data-lucide="mail" size="20" class="icon-input"></i>
                                <input type="date" name="tgl_lahir" placeholder="user@rsud-bp.com" class="form-control-custom" required>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="custom-label">Email</label>
                            <div class="input-group-custom">
                                <i data-lucide="mail" size="20" class="icon-input"></i>
                                <input type="email" name="email" placeholder="user@rsud-bp.com" class="form-control-custom" required>
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-md-6">
                            <label class="custom-label">No. Telepon</label>
                            <div class="input-group-custom">
                                <i data-lucide="phone" size="20" class="icon-input"></i>
                                <input type="tel" name="no_telp" placeholder="082" class="form-control-custom" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-12">
                            <label class="custom-label">Password</label>
                            <div class="input-group-custom">
                                <i data-lucide="lock" size="20" class="icon-input"></i>
                                <input type="password" name="password" placeholder="••••••••" class="form-control-custom" required>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn-register">
                                DAFTARKAN AKUN
                                <i data-lucide="arrow-right" size="18"></i>
                            </button>
                            <p class="text-center mt-4 small fw-medium text-muted">
                                Sudah punya akun?
                                <a href="../login/index.php" class="text-primary fw-bold text-decoration-none">Masuk Sekarang</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>

</html>