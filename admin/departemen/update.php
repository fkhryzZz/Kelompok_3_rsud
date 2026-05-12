<?php
require_once "../../config/db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama_departemen = $_POST['nama_departemen'];
    $judul_layanan   = $_POST['judul_layanan'];
    $deskripsi       = $_POST['deskripsi'];

        $id = $_GET['id'];
        
        try {
            $sql = "UPDATE tb_departemen SET 
                    nama_departemen = :nama_departemen, 
                    judul_layanan = :judul_layanan, 
                    deskripsi = :deskripsi 
                    WHERE id_departemen = :id";
            
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':nama_departemen', $nama_departemen);
            $stmt->bindParam(':judul_layanan', $judul_layanan);
            $stmt->bindParam(':deskripsi', $deskripsi);
            $stmt->bindParam(':id', $id);
            
            $stmt->execute();

            echo "<script>
                    alert('Data departemen berhasil diperbarui!');
                    window.location.href = 'index.php';
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
    header("Location: index.php");
    exit();
}
?>