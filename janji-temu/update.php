<?php
require_once "../db/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id           = $_POST['id'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $nik      = $_POST['nik'];
        $alamat       = $_POST['alamat'];

        $query = "UPDATE tb_pasien SET nama_lengkap = :nama_lengkap, nik = :nik, alamat = :alamat WHERE id_pasien = :id";
        $stmt = $conn->prepare($query);

        $stmt->execute([
            ':nama_lengkap' => $nama_lengkap,
            ':nik'      => $nik,
            ':alamat'       => $alamat,
            ':id'           => $id
        ]);

        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        echo "Error saat memperbarui data: " . $e->getMessage();
    }

    $conn = null;
}
?>