<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - RSUD Bakti Permana</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<section class="container-fluid cont-dokter">
    <div class="cont-table card shadow-sm border-0 p-4">
        <h1 class="mb-4 text-primary fw-bold">
            <i class="bi bi-hospital-fill"></i> Daftar Dokter
        </h1>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th class="py-3">No</th>
                        <th class="py-3">Nama Dokter</th>
                        <th class="py-3">Spesialis</th>
                        <th class="py-3">Jadwal Praktek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Data Array Dokter
                    $data_dokter = [
                        ["no" => "1", "nama" => "Dr. Andi Wijaya", "spesialis" => "Dokter Umum", "jadwal" => "Senin - Jumat, 08:00 - 16:00"],
                        ["no" => "2", "nama" => "Dr. Siti Rahmawati", "spesialis" => "Dokter Gigi", "jadwal" => "Senin - Jumat, 09:00 - 17:00"],
                        ["no" => "3", "nama" => "Dr. Budi Santoso", "spesialis" => "Spesialis Anak", "jadwal" => "Senin - Jumat, 10:00 - 18:00"],
                        ["no" => "4", "nama" => "dr. Siti Maharani, Sp.OG", "spesialis" => "Kebidanan", "jadwal" => "Selasa & Kamis, 13:00 - 15:00"]
                    ];

                    foreach ($data_dokter as $dokter): ?>
                        <tr>
                            <td><?= $dokter['no']; ?></td>
                            <td class="fw-medium"><?= $dokter['nama']; ?></td>
                            <td><span class="badge bg-info text-dark"><?= $dokter['spesialis']; ?></span></td>
                            <td><?= $dokter['jadwal']; ?></td>
                        </tr>b  
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>