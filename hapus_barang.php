<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    $sql = "DELETE FROM Barang WHERE id_barang = $id_barang";

    if ($conn->query($sql) === TRUE) {
        echo "Barang berhasil dihapus";
    } else {
        echo "Error menghapus barang: " . $conn->error;
    }
}
header("Location: daftar_barang.php");
?>
