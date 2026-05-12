<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RSUD Bakti Permana</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --primary-blue: #1e3a8a;
            /* Blue 900 */
            --bg-slate: #f8fafc;
            /* Slate 50 */
            --text-slate-800: #1e293b;
            --text-slate-400: #94a3b8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: url('../assets/images/bg.png');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1.5rem;
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 1100px;
            min-height: 700px;
            border-radius: 50px;
            box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.05);
            display: flex;
            overflow: hidden;
            border: 1px solid #f1f5f9;
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

        /* Form Section */
        .form-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .form-section {
                padding: 5rem;
            }
        }

        .brand-section {
            flex: 1;
            background-color: var(--primary-blue);
            position: relative;
            padding: 4rem;
            display: none;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .brand-section {
                display: flex;
            }
        }

        /* Form Styling */
        .form-label-custom {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--text-slate-400);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
            display: block;
            padding-left: 0.25rem;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-group-custom .icon-input {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #cbd5e1;
            width: 20px;
            height: 20px;
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            padding: 1rem 1rem 1rem 3.5rem;
            background-color: var(--bg-slate);
            border: 2px solid transparent;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-slate-800);
            transition: all 0.2s;
            outline: none;
        }

        .form-control-custom:focus {
            background-color: white;
            border-color: #dbeafe;
            box-shadow: 0 0 0 4px rgba(219, 234, 254, 0.5);
        }

        .btn-login {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 1.25rem;
            border-radius: 20px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            box-shadow: 0 10px 15px -3px rgba(30, 58, 138, 0.2);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-login:hover {
            background-color: #0f172a;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        /* Decorative Elements */
        .blur-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
        }

        .pattern-overlay {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            mix-blend-mode: overlay;
            opacity: 0.4;
        }

        .avatar-group {
            display: flex;
            padding-left: 10px;
        }

        .avatar-item {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid var(--primary-blue);
            margin-left: -10px;
            background-color: #e2e8f0;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <!-- Left Side: Form -->
        <div class="form-section">
            <div class="mb-5">
                <h1 class="h2 fw-bolder text-dark mb-1">Selamat Datang</h1>
                <p class="text-muted fw-medium">Silakan masuk ke akun Anda</p>
            </div>

            <form action="insert.php" method="POST">
                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label-custom">Email Address</label>
                    <div class="input-group-custom">
                        <i data-lucide="mail" class="icon-input"></i>
                        <input type="email" name="email" placeholder="user@rsud-bp.com" class="form-control-custom" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label-custom">Password</label>
                        <a href="#" class="text-decoration-none fw-bold text-primary" style="font-size: 0.65rem;">Lupa Password?</a>
                    </div>
                    <div class="input-group-custom">
                        <i data-lucide="lock" class="icon-input"></i>
                        <input type="password" name="password" placeholder="••••••••" class="form-control-custom" required>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label fw-bold text-muted" for="remember" style="font-size: 0.75rem; cursor: pointer;">
                        Tetap masuk selama 30 hari
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    MASUK KE DASHBOARD
                    <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                </button>
            </form>

            <p class="text-center mt-5 text-muted fw-medium" style="font-size: 0.75rem;">
                Belum punya akun?
                <a href="../register/index.php" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a>
            </p>
        </div>

        <!-- Right Side: Branding -->
        <div class="brand-section">
            <!-- Background Decorations -->
            <div class="blur-circle" style="top: 10%; right: 10%; width: 120px; height: 120px; background: rgba(255,255,255,0.1);"></div>
            <div class="blur-circle" style="bottom: 20%; left: -5%; width: 250px; height: 250px; background: rgba(34,211,238,0.1);"></div>

            <!-- Pattern Fallback (replace with your asset path) -->
            <img src="../assets/images/pattern.png" class="pattern-overlay" alt="">

            <div class="position-relative z-1">
                <img src="../assets/images/logo-white.png" alt="RSUD BP" style="width: 180px;">
            </div>

            <div class="position-relative z-1">
                <h2 class="display-4 fw-bolder mb-4 line-height-sm">
                    Digitalisasi<br>Layanan<br>Kesehatan.
                </h2>
                <p class="text-white-50 fw-medium lead" style="max-width: 380px; font-size: 1rem;">
                    Solusi manajemen rumah sakit terpadu untuk memberikan pelayanan terbaik bagi masyarakat.
                </p>
            </div>

            <div class="position-relative z-1 d-flex align-items-center gap-3 p-4 border border-white border-opacity-10 rounded-pill" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                <div class="avatar-group">
                    <div class="avatar-item"></div>
                    <div class="avatar-item"></div>
                    <div class="avatar-item"></div>
                </div>
                <span class="text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Dikelola oleh +24 Staf Admin</span>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Inisialisasi Ikon Lucide
        lucide.createIcons();
    </script>
</body>

</html>