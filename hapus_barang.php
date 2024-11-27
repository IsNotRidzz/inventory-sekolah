<?php
include 'koneksi.php';

// Pastikan id_barang diterima dengan benar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Menyiapkan statement untuk menghindari SQL Injection
    $sql = "DELETE FROM Barang WHERE id_barang = ?";
    $stmt = $conn->prepare($sql);

    // Mengikat parameter
    $stmt->bind_param("i", $id_barang);

    // Menjalankan query
    if ($stmt->execute()) {
        echo "Barang berhasil dihapus";
    } else {
        echo "Error menghapus barang: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
} else {
    echo "ID barang tidak valid.";
}

// Setelah penghapusan, redirect ke daftar_barang.php
header("Location: daftar_barang.php");
exit;
?>
