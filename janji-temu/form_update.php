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
<html>
<head>
    <title>Perbaharui Data Pasien</title>
</head>
<body>
    <h2>Perbaharui Data Pasien</h2>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $pasien['id_pasien'] ?>">

        <label>Nama Lengkap:</label><br>
        <input type="text" name="nama_lengkap" value="<?= $pasien['nama_lengkap'] ?>" required><br><br>

        <label>No Telp:</label><br>
        <input type="text" name="nik" value="<?= $pasien['nik'] ?>"><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat"><?= $pasien['alamat'] ?></textarea><br><br>

        <input type="submit" value="Simpan Perubahan">
        <a href="index.php">Batal</a>
    </form>
</body>
</html>