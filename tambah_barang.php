<?php 
include 'koneksi.php'; 
include 'navbar.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Barang</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" required><br>

            <label>Gambar Barang:</label>
            <input type="file" name="gambar_barang" accept="image/*"><br>

            <label>Merek:</label>
            <input type="text" name="merek_barang"><br>

            <label>Harga:</label>
            <input type="number" name="harga_barang"><br>

            <label>Jumlah:</label>
            <input type="number" name="jumlah_barang"><br>

            <label>Ruangan:</label>
            <select name="lokasi_sekarang">
                <?php
                $ruangan = $conn->query("SELECT * FROM Ruangan");
                while ($row = $ruangan->fetch_assoc()) {
                    echo "<option value='{$row['id_ruangan']}'>{$row['nama_ruangan']}</option>";
                }
                ?>
            </select><br><br>

            <button type="submit" name="submit">Tambah</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Ambil data input form
            $nama_barang = $_POST['nama_barang'];
            $merek_barang = $_POST['merek_barang'];
            $harga_barang = $_POST['harga_barang'];
            $jumlah_barang = $_POST['jumlah_barang'];
            $lokasi_sekarang = $_POST['lokasi_sekarang'];
            
            // Proses upload gambar
            $gambar = $_FILES['gambar_barang']['name'];
            $gambar_tmp = $_FILES['gambar_barang']['tmp_name'];
            $upload_dir = 'uploads/';
            
            // Cek apakah file gambar valid
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if ($_FILES['gambar_barang']['size'] > $max_size) {
                echo "<p class='error'>Ukuran file gambar terlalu besar. Maksimal 2MB.</p>";
                return; // Stop execution if the file is too large
            } elseif (!in_array($file_extension, $allowed_extensions)) {
                echo "<p class='error'>Ekstensi file tidak valid. Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.</p>";
                return; // Stop execution if the file extension is invalid
            } else {
                // Pindahkan file gambar ke direktori yang ditentukan
                $gambar_new_name = time() . '_' . $gambar;
                if (move_uploaded_file($gambar_tmp, $upload_dir . $gambar_new_name)) {
                    // Query untuk menyimpan data barang ke dalam database
                    $sql = $conn->prepare("INSERT INTO Barang (nama_barang, merek_barang, harga_barang, jumlah_barang, lokasi_sekarang, gambar) VALUES (?, ?, ?, ?, ?, ?)");
                    $sql->bind_param("ssdiis", $nama_barang, $merek_barang, $harga_barang, $jumlah_barang, $lokasi_sekarang, $gambar_new_name);

                    if ($sql->execute()) {
                        echo "<p class='success'>Barang berhasil ditambahkan.</p>";
                    } else {
                        echo "<p class='error'>Gagal menambahkan barang. Coba lagi nanti.</p>";
                    }
                } else {
                    echo "<p class='error'>Gagal mengupload gambar. Coba lagi nanti.</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
