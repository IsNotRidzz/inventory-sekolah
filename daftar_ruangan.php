<?php
include 'koneksi.php';
include 'navbar.php'; 
// Query untuk mengambil data ruangan
$sql = "SELECT * FROM Ruangan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Ruangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Ruangan</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Ruangan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Mengambil data dari database dan menampilkan tabel
                        $id_ruangan = $row['id_ruangan'];
                        echo "<tr>
                                <td>{$row['nama_ruangan']}</td>
                                <td>{$row['deskripsi']}</td>
                                <td>
                                    <a href='edit_ruangan.php?id={$id_ruangan}'>Edit</a> | 
                                    <a href='hapus_ruangan.php?id={$id_ruangan}'>Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Tidak ada ruangan tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
