<?php
// Memanggil koneksi database
require_once "../../../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Menangkap data dari form
    $id_ruangan          = $_POST['id_ruangan'];
    $id_departemen       = $_POST['id_departemen'];
    $nama_ruangan        = $_POST['nama_ruangan'];
    $kapasitas_maksimal  = $_POST['kapasitas_maksimal'];
    $status_ketersediaan = $_POST['status_ketersediaan'];

    try {
        // Query Update PDO
        $sql = "UPDATE tb_ruangan SET
                id_departemen = :id_departemen,
                nama_ruangan = :nama_ruangan,
                kapasitas_maksimal = :kapasitas_maksimal,
                status_ketersediaan = :status_ketersediaan
                WHERE id_ruangan = :id_ruangan";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_ruangan', $id_ruangan);
        $stmt->bindParam(':id_departemen', $id_departemen);
        $stmt->bindParam(':nama_ruangan', $nama_ruangan);
        $stmt->bindParam(':kapasitas_maksimal', $kapasitas_maksimal);
        $stmt->bindParam(':status_ketersediaan', $status_ketersediaan);

        $stmt->execute();

        // Redirect kembali ke halaman detail departemen
        echo "<script>
                alert('Data ruangan berhasil diperbarui!');
                window.location.href = '../detail.php?id=" . $id_departemen . "';
              </script>";
        exit();

    } catch (PDOException $e) {
        echo "<script>
                alert('Terjadi kesalahan database: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }

    $conn = null;
} else {
    header("Location: ../index.php");
    exit();
}
?>