<?php
session_start();
require_once "../config/db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // 1. Membuat string query dengan prepare statement untuk keamanan
        $stmt = $conn->prepare("SELECT * FROM tb_users WHERE email = :email");
        $stmt->bindParam(':email', $email); 
        
        // 2. Melakukan query  183]
        $stmt->execute();

        // 3. Menentukan hasil dalam bentuk asosiatif 
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetch(); 

        // 4. Verifikasi user dan password
        if ($user && password_verify($password, $user['password'])) {
            // Simpan data ke session
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['role'] = $user['role'];

            // 5. Redirect berdasarkan role (Logika ini dikembangkan dari fungsi header di modul)
            if ($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } elseif ($user['role'] == 'dokter') {
                header("Location: ../dokter/dashboard.php");
            } else {
                header("Location: ../home_pasien.php");
            }
            exit();
        } else {
            echo "Email atau Password salah!";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    // Memutus hubungan ke MySQL 
    $conn = null;
}
?>