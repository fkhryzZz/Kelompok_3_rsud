<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSUD Bakti Permana - Departemen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <div class="container-fluid">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="../assets/images/logo.png" alt="Logo" class="logo-image">
            </div>
            <nav>
                <ul>
                    <li><i class="fas fa-th-large"></i> Dashboard</li>
                    <li><i class="far fa-calendar-alt"></i> Janji Temu</li>
                    <li><i class="fas fa-user-injured"></i> Pasien</li>
                    <li><i class="fas fa-user-md"></i> Dokter</li>
                    <li><i class="fas fa-file-medical-alt"></i> Jadwal Dokter</li>
                    <li class="active"><i class="fas fa-hospital"></i> Departemen</li>
                    <li><i class="fas fa-wallet"></i> Pembayaran</li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Pencarian">
                </div>
                <div class="user-profile">
                    <div class="avatar">A</div>
                    <span>Admin <i class="fas fa-chevron-down"></i></span>
                </div>
            </header>

            <section class="card-grid">
                <?php
                // Data simulasi untuk kartu layanan
                $layanan = [
                    ["judul" => "Layanan Umum", "desc" => "Layanan kesehatan menyeluruh untuk keluarga."],
                    ["judul" => "Layanan Umum", "desc" => "Layanan kesehatan menyeluruh untuk keluarga."],
                    ["judul" => "Layanan Umum", "desc" => "Layanan kesehatan menyeluruh untuk keluarga."],
                    ["judul" => "Layanan Umum", "desc" => "Layanan kesehatan menyeluruh untuk keluarga."],
                    ["judul" => "Layanan Umum", "desc" => "Layanan kesehatan menyeluruh untuk keluarga."],
                    ["judul" => "Layanan Umum", "desc" => "Layanan kesehatan menyeluruh untuk keluarga."]
                ];

                foreach ($layanan as $item) : ?>
                    <div class="card">
                        <div class="card-image">
                        </div>
                        <div class="card-body">
                            <h3><?php echo $item['judul']; ?></h3>
                            <p><?php echo $item['desc']; ?></p>
                            <button class="btn-detail">LIHAT DETAIL</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </div>
</body>
</html>