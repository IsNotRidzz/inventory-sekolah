<?php
include 'koneksi.php';
include 'navbar.php';

// Query untuk mengambil riwayat perpindahan barang
$sql = "SELECT rp.*, b.nama_barang, ruang_asal.nama_ruangan AS asal, ruang_tujuan.nama_ruangan AS tujuan 
        FROM Riwayat_Pindah rp 
        JOIN Barang b ON rp.id_barang = b.id_barang 
        JOIN Ruangan ruang_asal ON rp.lokasi_asal = ruang_asal.id_ruangan 
        JOIN Ruangan ruang_tujuan ON rp.lokasi_tujuan = ruang_tujuan.id_ruangan 
        ORDER BY rp.tanggal_pindah DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Perpindahan Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Riwayat Perpindahan Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah Pindah</th>
                    <th>Ruangan Asal</th>
                    <th>Ruangan Tujuan</th>
                    <th>Tanggal Perpindahan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nama_barang']}</td>
                                <td>{$row['jumlah_pindah']}</td>
                                <td>{$row['asal']}</td>
                                <td>{$row['tujuan']}</td>
                                <td>{$row['tanggal_pindah']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada riwayat perpindahan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
