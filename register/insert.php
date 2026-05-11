<?php
// Memanggil koneksi database
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Menangkap data dari form
    $nama_lengkap  = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin']; // Dari form value: LAKI-LAKI / PEREMPUAN
    $tgl_lahir     = $_POST['tgl_lahir'];
    $email         = $_POST['email'];
    $no_telp       = $_POST['no_telp'];
    $password      = $_POST['password'];

    // Menyesuaikan format Jenis Kelamin dengan ENUM di database ('Laki-laki', 'Perempuan')
    if ($jenis_kelamin == 'LAKI-LAKI') {
        $jk_enum = 'Laki-laki';
    } else {
        $jk_enum = 'Perempuan';
    }

    // Mengenkripsi password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'pasien';

    try {
        // Memulai Transaksi Database
        $conn->beginTransaction();

        // ==========================================
        // TAHAP 1: Insert ke tb_users
        // ==========================================
        $sql_user = "INSERT INTO tb_users (email, password, role) VALUES (:email, :password, :role)";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bindParam(':email', $email);
        $stmt_user->bindParam(':password', $hashed_password);
        $stmt_user->bindParam(':role', $role);
        $stmt_user->execute();

        // Mengambil id_user yang baru saja di-generate oleh database (Auto Increment)
        $id_user_baru = $conn->lastInsertId();

        // ==========================================
        // TAHAP 2: Insert ke tb_pasien
        // ==========================================
        // Kolom alamat, tgl_kadaluarsa, status, foto_ktp, nik bisa bernilai NULL sesuai struktur DB
        $sql_pasien = "INSERT INTO tb_pasien (id_user, nama_lengkap, jenis_kelamin, tgl_lahir, no_telp) 
                       VALUES (:id_user, :nama_lengkap, :jenis_kelamin, :tgl_lahir, :no_telp)";
        
        $stmt_pasien = $conn->prepare($sql_pasien);
        $stmt_pasien->bindParam(':id_user', $id_user_baru);
        $stmt_pasien->bindParam(':nama_lengkap', $nama_lengkap);
        $stmt_pasien->bindParam(':jenis_kelamin', $jk_enum);
        $stmt_pasien->bindParam(':tgl_lahir', $tgl_lahir);
        $stmt_pasien->bindParam(':no_telp', $no_telp);
        $stmt_pasien->execute();

        // Jika kedua tahap di atas berhasil, simpan permanen ke database
        $conn->commit();

        // Redirect ke halaman login setelah registrasi sukses
        echo "<script>
                alert('Registrasi Berhasil! Silakan Login.');
                window.location.href = '../login/index.php';
              </script>";
        exit();

    } catch (PDOException $e) {
        // Jika terjadi error (misal email sudah terdaftar), batalkan semua perubahan (Rollback)
        $conn->rollBack();
        
        // Mengecek apakah error disebabkan oleh email duplicate (kode error 23000)
        if ($e->getCode() == 23000) {
            echo "<script>
                    alert('Error: Email sudah terdaftar. Gunakan email lain!');
                    window.history.back();
                  </script>";
        } else {
            echo "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }

    // Memutus koneksi database
    $conn = null;
}
?>