<?php
include 'koneksi.php';
include 'navbar.php'; 
// Pastikan ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id_ruangan = $_GET['id'];

    // Ambil data ruangan berdasarkan ID
    $sql = "SELECT * FROM Ruangan WHERE id_ruangan = $id_ruangan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_ruangan = $row['nama_ruangan'];
        $deskripsi = $row['deskripsi'];
    } else {
        echo "Ruangan tidak ditemukan.";
        exit;
    }
} else {
    echo "ID Ruangan tidak ditemukan.";
    exit;
}

if (isset($_POST['submit'])) {
    $nama_ruangan = $_POST['nama_ruangan'];
    $deskripsi = $_POST['deskripsi'];

    // Update data ruangan
    $sql = "UPDATE Ruangan SET nama_ruangan='$nama_ruangan', deskripsi='$deskripsi' WHERE id_ruangan=$id_ruangan";

    if ($conn->query($sql) === TRUE) {
        echo "Ruangan berhasil diperbarui.";
        header("Location: daftar_ruangan.php"); // Redirect kembali ke daftar ruangan setelah berhasil update
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Ruangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Ruangan</h2>
        <form action="" method="POST">
            <label for="nama_ruangan">Nama Ruangan:</label><br>
            <input type="text" name="nama_ruangan" value="<?php echo $nama_ruangan; ?>" required><br>

            <label for="deskripsi">Deskripsi:</label><br>
            <textarea name="deskripsi" required><?php echo $deskripsi; ?></textarea><br>

            <button type="submit" name="submit">Update Ruangan</button>
        </form>
    </div>
</body>
</html>
