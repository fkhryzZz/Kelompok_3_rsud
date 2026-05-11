<?php
session_start();
require_once "../config/db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM tb_users WHERE email = :email");
        $stmt->bindParam(':email', $email); 
        
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetch(); 

        if ($user && password_verify($password, $user['password'])) {
            // Simpan data ke session
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['role'] = $user['role'];

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
    
    $conn = null;
}
?>