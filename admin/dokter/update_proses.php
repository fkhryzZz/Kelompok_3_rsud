<?php
// Memanggil koneksi database
require_once "../../config/db.php";

// Memastikan data dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Mengambil data dari form
    $id_dokter = $_POST['id_dokter'];
    $id_user = $_POST['id_user'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama_dokter = $_POST['nama_dokter'];
    $no_str = $_POST['no_str'];
    $spesialisasi = $_POST['spesialisasi'];
    $id_departemen = $_POST['id_departemen'];

    try {
        // Memulai Transaksi Database
        $conn->beginTransaction();

        // ==========================================
        // TAHAP 1: Update tb_users (email dan password jika diisi)
        // ==========================================
        if (!empty($password)) {
            // Jika password diisi, hash dan update
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_user = "UPDATE tb_users SET email = :email, password = :password WHERE id_user = :id_user";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bindParam(':email', $email);
            $stmt_user->bindParam(':password', $hashed_password);
            $stmt_user->bindParam(':id_user', $id_user);
        } else {
            // Jika password kosong, hanya update email
            $sql_user = "UPDATE tb_users SET email = :email WHERE id_user = :id_user";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bindParam(':email', $email);
            $stmt_user->bindParam(':id_user', $id_user);
        }
        $stmt_user->execute();

        // ==========================================
        // TAHAP 2: Update tb_dokter
        // ==========================================
        $sql_dokter = "UPDATE tb_dokter SET 
                       no_str = :no_str, 
                       nama_dokter = :nama_dokter, 
                       spesialisasi = :spesialisasi, 
                       id_departemen = :id_departemen 
                       WHERE id_dokter = :id_dokter";
        
        $stmt_dokter = $conn->prepare($sql_dokter);
        $stmt_dokter->bindParam(':no_str', $no_str);
        $stmt_dokter->bindParam(':nama_dokter', $nama_dokter);
        $stmt_dokter->bindParam(':spesialisasi', $spesialisasi);
        $stmt_dokter->bindParam(':id_departemen', $id_departemen);
        $stmt_dokter->bindParam(':id_dokter', $id_dokter);
        $stmt_dokter->execute();

        // Commit transaksi
        $conn->commit();

        // Redirect ke halaman index dengan pesan sukses
        header("Location: index.php?status=success&message=Dokter berhasil diperbarui");
        exit();

    } catch (PDOException $e) {
        // Rollback transaksi jika terjadi error
        $conn->rollBack();
        echo "Terjadi kesalahan: " . $e->getMessage();
        exit();
    }
} else {
    // Jika bukan POST, redirect ke index
    header("Location: index.php");
    exit();
}
?>