<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_rumah-sakit";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nik     = $_POST['nik'];
    $layanan     = $_POST['layanan'];
    $tgl_janji   = $_POST['tgl_janji'];
    $jam_janji   = $_POST['jam_janji'];
    $email          = $_POST['email'];

    $alamat         = "-";         
    $status_anggota = "AKTIF";      
    $fk_dokter      = 1;           
    $id_ruangan     = 1;            
    $status_janji   = "menunggu";   

    $conn->begin_transaction();

    try {
        $query_pasien = "INSERT INTO tb_pasien (nik, email, alamat, status_anggota) VALUES (?, ?, ?, ?)";
        $stmt_pasien = $conn->prepare($query_pasien);
        
        $stmt_pasien->bind_param("ssss", $nik, $email, $alamat, $status_anggota);
        $stmt_pasien->execute();

        $id_pasien_baru = $conn->insert_id;

        $query_janji = "INSERT INTO tb_janji_temu (fk_pasien, fk_dokter, tgl_janji, jam_janji, id_ruangan, status_janji) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_janji = $conn->prepare($query_janji);
        
        $stmt_janji->bind_param("iissis", $id_pasien_baru, $fk_dokter, $tgl_janji, $jam_janji, $id_ruangan, $status_janji);
        $stmt_janji->execute();

        $conn->commit();

        echo "<script>
                alert('Pendaftaran berhasil! Nomor ID Pasien Anda: $id_pasien_baru');
                window.location.href = 'index.html'; // Ganti dengan nama file HTML form Anda
              </script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "Pendaftaran gagal terjadi kesalahan: " . $e->getMessage();
    }

    if(isset($stmt_pasien)) $stmt_pasien->close();
    if(isset($stmt_janji)) $stmt_janji->close();
    $conn->close();
} else {
    echo "Metode tidak diizinkan.";
}
?>