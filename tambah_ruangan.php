<?php
include 'koneksi.php';
include 'navbar.php'; 
// Proses tambah ruangan ketika form disubmit
if (isset($_POST['submit'])) {
    $nama_ruangan = $_POST['nama_ruangan'];
    $deskripsi = $_POST['deskripsi'];

    // Query untuk memasukkan data ruangan ke dalam database
    $sql = "INSERT INTO Ruangan (nama_ruangan, deskripsi) VALUES ('$nama_ruangan', '$deskripsi')";

    if ($conn->query($sql) === TRUE) {
        echo "Ruangan berhasil ditambahkan.";
        header("Location: daftar_ruangan.php"); // Redirect ke daftar ruangan setelah berhasil tambah
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Ruangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Ruangan</h2>
        <form action="" method="POST">
            <label for="nama_ruangan">Nama Ruangan:</label><br>
            <input type="text" name="nama_ruangan" required><br>

            <label for="deskripsi">Deskripsi:</label><br>
            <textarea name="deskripsi" required></textarea><br>

            <button type="submit" name="submit">Tambah Ruangan</button>
        </form>
    </div>
</body>
</html>
