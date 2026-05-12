<?php
// Memanggil koneksi database
require_once "../../config/db.php";

// Memastikan data dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Menangkap data kredensial (tb_users)
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = 'dokter';

    // Mengenkripsi password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 2. Menangkap data profil dokter (tb_dokter)
    $nama_dokter   = $_POST['nama_dokter'];
    $no_str        = $_POST['no_str'];
    $spesialisasi  = $_POST['spesialisasi'];
    $id_departemen = $_POST['id_departemen'];

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
        // TAHAP 2: Insert ke tb_dokter
        // ==========================================
        $sql_dokter = "INSERT INTO tb_dokter (no_str, nama_dokter, spesialisasi, id_departemen, id_user) 
                       VALUES (:no_str, :nama_dokter, :spesialisasi, :id_departemen, :id_user)";
        
        $stmt_dokter = $conn->prepare($sql_dokter);
        $stmt_dokter->bindParam(':no_str', $no_str);
        $stmt_dokter->bindParam(':nama_dokter', $nama_dokter);
        $stmt_dokter->bindParam(':spesialisasi', $spesialisasi);
        $stmt_dokter->bindParam(':id_departemen', $id_departemen);
        $stmt_dokter->bindParam(':id_user', $id_user_baru); // Gunakan ID dari Tahap 1
        $stmt_dokter->execute();

        // Jika kedua tahap di atas berhasil tanpa error, simpan permanen ke database
        $conn->commit();

        // Redirect ke halaman data dokter dengan pesan sukses
        echo "<script>
                alert('Data dokter dan akun login berhasil ditambahkan!');
                window.location.href = 'index.php';
              </script>";
        exit();

    } catch (PDOException $e) {
        // Jika terjadi error di tengah proses, batalkan semua kueri (Rollback)
        $conn->rollBack();
        
        // Mengecek apakah error disebabkan oleh duplikasi data (kode error 23000), misal email/str sudah ada
        if ($e->getCode() == 23000) {
            echo "<script>
                    alert('Gagal: Email sudah terdaftar! Silakan gunakan email lain.');
                    window.history.back();
                  </script>";
        } else {
            // Menampilkan pesan error sistem jika ada kendala lain
            echo "<script>
                    alert('Terjadi kesalahan sistem: " . addslashes($e->getMessage()) . "');
                    window.history.back();
                  </script>";
        }
    }

    // Memutus koneksi database
    $conn = null;

} else {
    // Jika diakses langsung via URL tanpa form, tendang kembali ke halaman dokter
    header("Location: index.php");
    exit();
}
?>