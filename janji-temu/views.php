<?php
require_once "../db/db.php"; 

try {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM tb_pasien WHERE id_pasien = :id");
    
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $pasien = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pasien) {
        die("Data pasien tidak ditemukan!");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pasien</title>
</head>
<body>
    <h2>Detail Data Pasien</h2>
    
    <nav>
        <a href="index.php">Kembali ke Daftar</a> | 
        <a href="form_update.php?id=<?= $pasien['id_pasien'] ?>">Perbaharui</a> | 
        <a href="delete.php?id=<?= $pasien['id_pasien'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
    </nav>
    <hr>

    <table border="0" cellpadding="5">
        <tr>
            <td><strong>ID Pasien</strong></td>
            <td>: <?= $pasien['id_pasien'] ?></td>
        </tr>
        <tr>
            <td><strong>Nama Lengkap</strong></td>
            <td>: <?= $pasien['nama_lengkap'] ?></td>
        </tr>
        <tr>
            <td><strong>No. WhatsApp</strong></td>
            <td>: <?= $pasien['no_telp'] ?></td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td>: <?= $pasien['email'] ?></td>
        </tr>
        <tr>
            <td><strong>Alamat</strong></td>
            <td>: <?= $pasien['alamat'] ?></td>
        </tr>
        <tr>
            <td><strong>Status Anggota</strong></td>
            <td>: <?= $pasien['status_anggota'] ?></td>
        </tr>
    </table>

</body>
</html>

<?php
$conn = null;
?>