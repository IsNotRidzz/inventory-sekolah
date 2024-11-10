<?php
include 'koneksi.php';
include 'navbar.php'; 
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    $sql = "SELECT * FROM Barang WHERE id_barang = $id_barang";
    $result = $conn->query($sql);
    $barang = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $nama_barang = $_POST['nama_barang'];
    $merek_barang = $_POST['merek_barang'];
    $harga_barang = $_POST['harga_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $lokasi_sekarang = $_POST['lokasi_sekarang'];

    $sql = "UPDATE Barang SET 
            nama_barang='$nama_barang', 
            merek_barang='$merek_barang', 
            harga_barang='$harga_barang', 
            jumlah_barang='$jumlah_barang', 
            lokasi_sekarang='$lokasi_sekarang' 
            WHERE id_barang=$id_barang";

    if ($conn->query($sql) === TRUE) {
        echo "Barang berhasil diperbarui";
        header("Location: daftar_barang.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 1.1em;
            color: #333;
        }

        input, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            background-color: #f9f9f9;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .success {
            color: green;
            font-size: 1.1em;
        }

        .error {
            color: red;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Barang</h2>
        <form action="" method="post">
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>" required>
            
            <label>Merek:</label>
            <input type="text" name="merek_barang" value="<?php echo $barang['merek_barang']; ?>">
            
            <label>Harga:</label>
            <input type="number" name="harga_barang" value="<?php echo $barang['harga_barang']; ?>">
            
            <label>Jumlah:</label>
            <input type="number" name="jumlah_barang" value="<?php echo $barang['jumlah_barang']; ?>">
            
            <label>Ruangan:</label>
            <select name="lokasi_sekarang">
                <?php
                $ruangan = $conn->query("SELECT * FROM Ruangan");
                while ($row = $ruangan->fetch_assoc()) {
                    $selected = ($row['id_ruangan'] == $barang['lokasi_sekarang']) ? 'selected' : '';
                    echo "<option value='{$row['id_ruangan']}' $selected>{$row['nama_ruangan']}</option>";
                }
                ?>
            </select>
            
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
