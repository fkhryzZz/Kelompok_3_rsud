<?php
require_once "../../config/db.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID departemen tidak ditemukan!'); window.location.href='index.php';</script>";
    exit();
}

$id = $_GET['id'];

try {
    // Cek apakah departemen memiliki ruangan yang terkait
    $sql_check = "SELECT COUNT(*) as total_ruangan FROM tb_ruangan WHERE id_departemen = :id";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':id', $id);
    $stmt_check->execute();
    $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($result['total_ruangan'] > 0) {
        echo "<script>
                alert('Departemen tidak dapat dihapus karena masih memiliki " . $result['total_ruangan'] . " ruangan terkait. Hapus ruangan terlebih dahulu.');
                window.location.href = 'index.php';
              </script>";
        exit();
    }

    // Jika tidak ada ruangan, lanjut hapus departemen
    $sql = "DELETE FROM tb_departemen WHERE id_departemen = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "<script>
            alert('Departemen berhasil dihapus!');
            window.location.href = 'index.php';
          </script>";
    exit();

} catch (PDOException $e) {
    echo "<script>
            alert('Terjadi kesalahan database: " . addslashes($e->getMessage()) . "');
            window.location.href = 'index.php';
          </script>";
}

$conn = null;
?>