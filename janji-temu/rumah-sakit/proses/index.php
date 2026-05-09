<?php 
require_once '../db.php';

$stmt = $conn->prepare("SELECT * FROM pasien");
$stmt->execute();

$pasien = $stmt->setFetchMode(PDO::FETCH_ASSOC);

$rumah_sakit = $stmt->fetchAll();

echo "<b> Menampilkan data pasien</b>";
echo "<pre>";
print_r($rumah_sakit);
echo "</pre>";

echo "</b>Mengakses item array</b>";
foreach ($rumah_sakit as $pasien) {
    echo "<pre>";
    print($pasien);
    echo "</pre>";
}

echo "<b> Menampilkan isi table</b>";
echo "<table border='1'>";
foreach ($rumah_sakit as $pasien) {
    echo "<tr>
     <td>" . $pasien['id_pasien'] . "</td>
     <td>" . $pasien['nama_lengkap'] . "</td>
     <td>" . $pasien['alamat'] . "</td>
     <td>" . $pasien['no_tlp'] . "</td>";?>
     <td>
        <a href="delete.php?id=<?=$pasien['id']?>"> Hapus </a>
        <a href="edit.php?id=<?=$pasien['id']?>"> Update </a>
    </td>
    <?php
    echo "</tr>";
}

    echo "</table>";

    $conn = null;
