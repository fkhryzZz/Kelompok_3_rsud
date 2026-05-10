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
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <img src="../assets/images/search.svg" alt="Search Icon" class="search-icon">
                    <input type="text" placeholder="Pencarian">
                </div>
                <div class="user-profile">
                    <div class="avatar">A</div>
                    <span>Admin <i class="fas fa-chevron-down"></i></span>
                </div>
            </header>

            <section class="card-grid">
                <?php
// 1. Data harus dipisah per item (Poli)
$layanan = [
    [
        "judul"  => "Poli Umum",
        "desc"   => "Layanan kesehatan menyeluruh.",
        "gambar" => "../assets/images/poliumum.png" // Unik untuk Poli Umum
    ],
    [
        "judul"  => "Poli Gigi",
        "desc"   => "Layanan kesehatan gigi dan mulut.",
        "gambar" => "../assets/images/poligigi.jpg" // Unik untuk Poli Gigi
    ],
    [
        "judul"  => "Poli Kandungan",
        "desc"   => "Layanan kesehatan khusus ibu hamil dan nifas.",
        "gambar" => "../assets/images/poli-kandungan.jpg" // Unik untuk Poli Kandungan
    ],
    [
        "judul"  => "Poli Anak",
        "desc"   => "Layanan kesehatan khusus anak-anak.",
        "gambar" => "../assets/images/polianak.jpg" // Unik untuk Poli Anak
    ],
    [
        "judul"  => "Poli Bedah",
        "desc"   => "Layanan kesehatan untuk tindakan bedah.",
        "gambar" => "../assets/images/polibedah.jpg" // Unik untuk Poli Bedah
    ]
];
?>

<div class="container-layanan">
    <?php foreach ($layanan as $item) : ?>
        <div class="card">
            <div class="card-image">
                <img src="<?php echo $item['gambar']; ?>" alt="Gambar Layanan">
            </div>
            <div class="card-body">
                <h3><?php echo $item['judul']; ?></h3>
                <p><?php echo $item['desc']; ?></p>
                <button>LIHAT DETAIL</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>