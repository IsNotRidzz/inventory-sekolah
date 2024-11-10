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

    $sql = "UPDATE Barang SET lokasi_sekarang='$lokasi_baru' WHERE id_barang=$id_barang";

    if ($conn->query($sql) === TRUE) {
        echo "Barang berhasil dipindahkan";
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
    <title>Pindah Barang</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
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
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            background-color: #f9f9f9;
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
        <h2>Pindah Barang</h2>
        <p>Memindahkan barang: <strong><?php echo $barang['nama_barang']; ?></strong></p>
        
        <form action="" method="post">
            <label>Ruangan Baru:</label><br>
            <select name="lokasi_baru">
                <?php
                $ruangan = $conn->query("SELECT * FROM Ruangan");
                while ($row = $ruangan->fetch_assoc()) {
                    $selected = ($row['id_ruangan'] == $barang['lokasi_sekarang']) ? 'selected' : '';
                    echo "<option value='{$row['id_ruangan']}' $selected>{$row['nama_ruangan']}</option>";
                }
                ?>
            </select><br><br>
            
            <button type="submit" name="pindah">Pindah</button>
        </form>
    </div>
</body>
</html>
