<?php
// Memanggil koneksi database
require_once "../../../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Menangkap data dari form
    $id_departemen       = $_POST['id_departemen'];
    $nama_ruangan        = $_POST['nama_ruangan'];
    $kapasitas_maksimal  = $_POST['kapasitas_maksimal'];
    $status_ketersediaan = $_POST['status_ketersediaan'];
    
    // Default pasien saat ini selalu 0 saat ruangan baru dibuat
    $jumlah_pasien_saat_ini = 0; 

    try {
        // Query Insert PDO
        $sql = "INSERT INTO tb_ruangan 
                (id_departemen, nama_ruangan, kapasitas_maksimal, jumlah_pasien_saat_ini, status_ketersediaan) 
                VALUES 
                (:id_departemen, :nama_ruangan, :kapasitas_maksimal, :jumlah_pasien_saat_ini, :status_ketersediaan)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':id_departemen', $id_departemen);
        $stmt->bindParam(':nama_ruangan', $nama_ruangan);
        $stmt->bindParam(':kapasitas_maksimal', $kapasitas_maksimal);
        $stmt->bindParam(':jumlah_pasien_saat_ini', $jumlah_pasien_saat_ini);
        $stmt->bindParam(':status_ketersediaan', $status_ketersediaan);
        
        $stmt->execute();

        // Redirect kembali ke halaman detail departemen agar pengguna bisa langsung melihat ruangannya
        echo "<script>
                alert('Ruangan baru berhasil ditambahkan!');
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