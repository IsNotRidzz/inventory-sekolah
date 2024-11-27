<?php
include 'koneksi.php';
include 'navbar.php';

// Query untuk mengambil semua ruangan
$sql_ruangan = "SELECT * FROM Ruangan";
$result_ruangan = $conn->query($sql_ruangan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            margin: 20px auto;
            width: 90%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .ruangan-section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .ruangan-section h3 {
            margin-bottom: 10px;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
        }

        .img-thumbnail {
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .img-thumbnail:hover {
            transform: scale(1.1);
        }

        .no-barang {
            text-align: center;
            color: #888;
            font-style: italic;
        }

        .total-row {
            font-weight: bold;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Barang Berdasarkan Ruangan</h2>
        
        <?php
        if ($result_ruangan->num_rows > 0) {
            while ($ruangan = $result_ruangan->fetch_assoc()) {
                $id_ruangan = $ruangan['id_ruangan'];
                $nama_ruangan = $ruangan['nama_ruangan'];

                // Query untuk mengambil barang berdasarkan ruangan yang memiliki jumlah lebih dari 0
                $sql_barang = "SELECT * FROM Barang WHERE lokasi_sekarang = $id_ruangan AND jumlah_barang > 0";
                $result_barang = $conn->query($sql_barang);
        ?>
        
        <div class="ruangan-section">
            <h3>Ruangan: <?php echo $nama_ruangan; ?></h3>
            <?php if ($result_barang->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Gambar</th>
                        <th>Harga</th>
                        <th>Merek</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_jumlah = 0;
                    $total_harga = 0;
                    while ($barang = $result_barang->fetch_assoc()) {
                        $id_barang = $barang['id_barang'];
                        $gambar = $barang['gambar'] ? "<img src='uploads/{$barang['gambar']}' alt='{$barang['nama_barang']}' width='50' class='img-thumbnail'>" : 'No Image';
                        $total_jumlah += $barang['jumlah_barang'];
                        $total_harga += $barang['harga_barang'] * $barang['jumlah_barang'];
                        echo "<tr>
                                <td>{$barang['nama_barang']}</td>
                                <td>{$gambar}</td>
                                <td>{$barang['harga_barang']}</td>
                                <td>{$barang['merek_barang']}</td>
                                <td>{$barang['jumlah_barang']}</td>
                                <td>{$barang['tanggal']}</td>
                                <td>
                                    <a href='edit_barang.php?id={$id_barang}'>Edit</a> | 
                                    <a href='hapus_barang.php?id={$id_barang}'>Hapus</a> | 
                                    <a href='pindah_barang.php?id={$id_barang}'>Pindah</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <!-- Menambahkan baris total jumlah dan harga -->
            <table>
                <tr class="total-row">
                    <td colspan="4">Total Jumlah Barang</td>
                    <td><?php echo $total_jumlah; ?></td>
                    <td colspan="2"></td>
                </tr>
                <tr class="total-row">
                    <td colspan="4">Total Harga Barang</td>
                    <td><?php echo number_format($total_harga, 2); ?></td>
                    <td colspan="2"></td>
                </tr>
            </table>
            <?php } else { ?>
            <p class="no-barang">Tidak ada barang di ruangan ini.</p>
            <?php } ?>
        </div>
        
        <?php
            }
        } else {
            echo "<p class='no-barang'>Tidak ada ruangan tersedia.</p>";
        }
        ?>
    </div>
</body>
</html>
