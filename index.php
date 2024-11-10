<?php 
include 'koneksi.php'; 

// Menghitung total ruangan
$total_ruangan = $conn->query("SELECT COUNT(*) AS total FROM Ruangan")->fetch_assoc()['total'];

// Menghitung total barang
$total_barang = $conn->query("SELECT COUNT(*) AS total FROM Barang")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Inventory Sekolah</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Gaya CSS seperti sebelumnya */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 40px;
        }
        .stat-card {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 30%;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .stat-card h3 {
            color: #4caf50;
            font-size: 2em;
        }
        .stat-card p {
            color: #666;
            font-size: 1.1em;
        }
        .stat-card .icon {
            font-size: 40px;
            color: #4caf50;
        }
        .links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }
        .links a {
            background-color: #4caf50;
            color: #ffffff;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.1em;
            transition: background-color 0.3s;
        }
        .links a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Inventory Sekolah</h1>

        <div class="stats">
            <!-- Card Total Ruangan -->
            <div class="stat-card">
                <div class="icon">🏢</div>
                <h3><?php echo $total_ruangan; ?></h3>
                <p>Total Ruangan</p>
            </div>
            <!-- Card Total Barang -->
            <div class="stat-card">
                <div class="icon">📦</div>
                <h3><?php echo $total_barang; ?></h3>
                <p>Total Barang</p>
            </div>
        </div>

        <div class="links">
            <!-- Links to navigate to different pages -->
            <a href="daftar_barang.php">Daftar Barang</a>
            <a href="daftar_ruangan.php">Daftar Ruangan</a>
            <a href="tambah_barang.php">Tambah Barang</a>
            <a href="tambah_ruangan.php">Tambah Ruangan</a>
        </div>
    </div>
</body>
</html>
