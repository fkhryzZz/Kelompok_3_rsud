<?php
// Memanggil koneksi database
require_once "../../../config/db.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID ruangan tidak ditemukan!'); window.location.href='../index.php';</script>";
    exit();
}

$id_ruangan = $_GET['id'];

try {
    // Cek apakah ruangan memiliki pasien
    $sql_check = "SELECT jumlah_pasien_saat_ini FROM tb_ruangan WHERE id_ruangan = :id_ruangan";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':id_ruangan', $id_ruangan);
    $stmt_check->execute();
    $ruangan = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if (!$ruangan) {
        echo "<script>alert('Ruangan tidak ditemukan!'); window.location.href='../index.php';</script>";
        exit();
    }

    if ($ruangan['jumlah_pasien_saat_ini'] > 0) {
        echo "<script>
                alert('Ruangan tidak dapat dihapus karena masih memiliki " . $ruangan['jumlah_pasien_saat_ini'] . " pasien. Pindahkan pasien terlebih dahulu.');
                window.history.back();
              </script>";
        exit();
    }

    // Ambil id_departemen untuk redirect
    $sql_dept = "SELECT id_departemen FROM tb_ruangan WHERE id_ruangan = :id_ruangan";
    $stmt_dept = $conn->prepare($sql_dept);
    $stmt_dept->bindParam(':id_ruangan', $id_ruangan);
    $stmt_dept->execute();
    $dept = $stmt_dept->fetch(PDO::FETCH_ASSOC);
    $id_departemen = $dept['id_departemen'];

    // Hapus ruangan
    $sql = "DELETE FROM tb_ruangan WHERE id_ruangan = :id_ruangan";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_ruangan', $id_ruangan);
    $stmt->execute();

    echo "<script>
            alert('Ruangan berhasil dihapus!');
            window.location.href = '../detail.php?id=" . $id_departemen . "';
          </script>";
    exit();

} catch (PDOException $e) {
    echo "<script>
            alert('Terjadi kesalahan database: " . addslashes($e->getMessage()) . "');
            window.location.href = '../index.php';
          </script>";
}

$conn = null;
?>