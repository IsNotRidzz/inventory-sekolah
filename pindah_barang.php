<?php
include 'koneksi.php';
include 'navbar.php';

if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    $sql = "SELECT * FROM Barang WHERE id_barang = $id_barang";
    $result = $conn->query($sql);
    $barang = $result->fetch_assoc();
}

if (isset($_POST['pindah'])) {
    $lokasi_baru = $_POST['lokasi_baru'];
    $jumlah_pindah = $_POST['jumlah_pindah'];

    // Validasi jumlah barang dan cek jika lokasi baru sama dengan lokasi asal
    if ($jumlah_pindah > 0 && $jumlah_pindah <= $barang['jumlah_barang']) {
        if ($lokasi_baru == $barang['lokasi_sekarang']) {
            // Lokasi baru sama dengan lokasi asal, tampilkan pesan error
            echo "<p class='error'>Barang tidak bisa dipindahkan ke ruangan yang sama!</p>";
        } else {
            // Kurangi jumlah barang dari ruangan asal
            $jumlah_tersisa = $barang['jumlah_barang'] - $jumlah_pindah;
            $conn->query("UPDATE Barang SET jumlah_barang = $jumlah_tersisa WHERE id_barang = $id_barang");

            // Cek apakah barang sudah ada di ruangan baru
            $sql_cek = "SELECT * FROM Barang WHERE nama_barang = '{$barang['nama_barang']}' AND lokasi_sekarang = $lokasi_baru";
            $result_cek = $conn->query($sql_cek);

            if ($result_cek->num_rows > 0) {
                // Jika barang sudah ada, tambahkan jumlahnya
                $row = $result_cek->fetch_assoc();
                $jumlah_baru = $row['jumlah_barang'] + $jumlah_pindah;
                $conn->query("UPDATE Barang SET jumlah_barang = $jumlah_baru WHERE id_barang = {$row['id_barang']}");
            } else {
                // Jika barang belum ada, buat entri baru
                $conn->query("INSERT INTO Barang (nama_barang, gambar, harga_barang, merek_barang, jumlah_barang, lokasi_sekarang, tanggal) 
                              VALUES ('{$barang['nama_barang']}', '{$barang['gambar']}', '{$barang['harga_barang']}', '{$barang['merek_barang']}', 
                              $jumlah_pindah, $lokasi_baru, '{$barang['tanggal']}')");
            }

            // Simpan riwayat perpindahan barang
            $sql_riwayat = "INSERT INTO Riwayat_Pindah (id_barang, jumlah_pindah, lokasi_asal, lokasi_tujuan) 
                            VALUES ($id_barang, $jumlah_pindah, {$barang['lokasi_sekarang']}, $lokasi_baru)";
            $conn->query($sql_riwayat);

            // Redirect ke halaman riwayat perpindahan
            header("Location: riwayat_pindah.php");
        }
    } else {
        echo "<p class='error'>Jumlah barang yang dipindahkan tidak valid!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pindah Barang</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Sama seperti style sebelumnya */
    </style>
</head>
<body>
    <div class="container">
        <h2>Pindah Barang</h2>
        <p>Memindahkan barang: <strong><?php echo $barang['nama_barang']; ?></strong></p>
        <p>Jumlah tersedia: <strong><?php echo $barang['jumlah_barang']; ?></strong></p>
        
        <form action="" method="post">
            <label>Ruangan Baru:</label><br>
            <select name="lokasi_baru">
                <?php
                $ruangan = $conn->query("SELECT * FROM Ruangan");
                while ($row = $ruangan->fetch_assoc()) {
                    echo "<option value='{$row['id_ruangan']}'>{$row['nama_ruangan']}</option>";
                }
                ?>
            </select><br><br>

            <label>Jumlah Barang yang Dipindahkan:</label><br>
            <input type="number" name="jumlah_pindah" min="1" max="<?php echo $barang['jumlah_barang']; ?>" required><br><br>
            
            <button type="submit" name="pindah">Pindah</button>
        </form>
    </div>
</body>
</html>
