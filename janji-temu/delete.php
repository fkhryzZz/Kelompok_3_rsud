<?php
require_once "../db/db.php"; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->beginTransaction();

    try {
        $query_janji = "DELETE FROM tb_janji_temu WHERE fk_pasien = :id";
        $stmt_janji = $conn->prepare($query_janji);
        $stmt_janji->execute([':id' => $id]);

        $query_pasien = "DELETE FROM tb_pasien WHERE id_pasien = :id";
        $stmt_pasien = $conn->prepare($query_pasien);
        $stmt_pasien->execute([':id' => $id]);

        $conn->commit();

        header("Location: index.php");
        exit();

    } catch (Exception $e) {
        $conn->rollBack();
        echo "Gagal menghapus data. Error: " . $e->getMessage();
    }

    $conn = null;
}
?>