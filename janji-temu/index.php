<?php
require_once "../db/db.php"; 

$sql = "SELECT * FROM tb_pasien ORDER BY id_pasien DESC";
$stmt = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pasien</title>
    <style>table { border-collapse: collapse; width: 100%; } th, td { padding: 8px; text-align: left; }</style>
</head>
<body>
    <h2>Daftar Pasien</h2>
    <a href="index.html">Tambah Pasien Baru</a> <br><br>

    <table border="1">
        <tr>
            <th>ID Pasien</th>
            <th>Nama Lengkap</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php
        if ($stmt && $stmt->rowCount() > 0) {
            while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $p['id_pasien'] . "</td>";
                echo "<td>" . $p['nama_lengkap'] . "</td>";
                echo "<td>" . $p['no_telp'] . "</td>";
                echo "<td>" . $p['alamat'] . "</td>";
                echo "<td>
                        <a href='views.php?id=" . $p['id_pasien'] . "'>Detail</a> |
                        <a href='form_update.php?id=" . $p['id_pasien'] . "'>Perbaharui</a> |
                        <a href='delete.php?id=" . $p['id_pasien'] . "' onclick='return confirm(\"Yakin ingin menghapus pasien ini?\")'>Hapus</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data pasien.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php 
// Menutup koneksi PDO
$conn = null; 
?>