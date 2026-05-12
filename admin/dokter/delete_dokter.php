<?php
// Memanggil koneksi database
require_once "../../config/db.php";

// Memastikan ada parameter id
if (isset($_GET['id'])) {
    $id_dokter = $_GET['id'];

    try {
        // Memulai Transaksi Database
        $conn->beginTransaction();

        // ==========================================
        // TAHAP 1: Ambil id_user dari tb_dokter
        // ==========================================
        $sql_get_user = "SELECT id_user FROM tb_dokter WHERE id_dokter = :id_dokter";
        $stmt_get_user = $conn->prepare($sql_get_user);
        $stmt_get_user->bindParam(':id_dokter', $id_dokter);
        $stmt_get_user->execute();
        $dokter = $stmt_get_user->fetch(PDO::FETCH_ASSOC);

        if (!$dokter) {
            header("Location: index.php?status=error&message=Dokter tidak ditemukan");
            exit();
        }

        $id_user = $dokter['id_user'];

        // ==========================================
        // TAHAP 2: Hapus dari tb_dokter
        // ==========================================
        $sql_delete_dokter = "DELETE FROM tb_dokter WHERE id_dokter = :id_dokter";
        $stmt_delete_dokter = $conn->prepare($sql_delete_dokter);
        $stmt_delete_dokter->bindParam(':id_dokter', $id_dokter);
        $stmt_delete_dokter->execute();

        // ==========================================
        // TAHAP 3: Hapus dari tb_users
        // ==========================================
        $sql_delete_user = "DELETE FROM tb_users WHERE id_user = :id_user";
        $stmt_delete_user = $conn->prepare($sql_delete_user);
        $stmt_delete_user->bindParam(':id_user', $id_user);
        $stmt_delete_user->execute();

        // Commit transaksi
        $conn->commit();

        // Redirect ke halaman index dengan pesan sukses
        header("Location: index.php?status=success&message=Dokter berhasil dihapus");
        exit();

    } catch (PDOException $e) {
        // Rollback transaksi jika terjadi error
        $conn->rollBack();
        echo "Terjadi kesalahan: " . $e->getMessage();
        exit();
    }
} else {
    // Jika tidak ada id, redirect ke index
    header("Location: index.php");
    exit();
}
?>