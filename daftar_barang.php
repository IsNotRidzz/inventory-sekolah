<?php
include 'koneksi.php';
include 'navbar.php'; 

// Query untuk mengambil data barang dan nama ruangan
$sql = "SELECT Barang.*, Ruangan.nama_ruangan 
        FROM Barang 
        JOIN Ruangan ON Barang.lokasi_sekarang = Ruangan.id_ruangan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Gaya untuk image preview saat diklik */
        .img-thumbnail {
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .img-thumbnail:hover {
            transform: scale(1.1);
        }

        /* Gaya untuk modal yang menampilkan gambar perbesar */
        .modal {
            display: none; 
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Merek</th>
                    <th>Jumlah</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Mengambil data dari database dan menampilkan tabel
                        $id_barang = $row['id_barang'];
                        $gambar = $row['gambar'] ? "<img src='uploads/{$row['gambar']}' alt='{$row['nama_barang']}' width='50' class='img-thumbnail' onclick='openModal(\"uploads/{$row['gambar']}\")'>" : 'No Image';
                        echo "<tr>
                                <td>{$row['nama_barang']}</td>
                                <td>{$gambar}</td>
                                <td>{$row['harga_barang']}</td>
                                <td>{$row['merek_barang']}</td>
                                <td>{$row['jumlah_barang']}</td>
                                <td>{$row['nama_ruangan']}</td> <!-- Menampilkan nama ruangan -->
                                <td>{$row['tanggal']}</td>
                                <td>
                                    <a href='edit_barang.php?id={$id_barang}'>Edit</a> | 
                                    <a href='hapus_barang.php?id={$id_barang}'>Hapus</a> | 
                                    <a href='pindah_barang.php?id={$id_barang}'>Pindah</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada barang tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal untuk menampilkan gambar perbesar -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        // Fungsi untuk membuka modal dengan gambar besar
        function openModal(imageSrc) {
            var modal = document.getElementById("imageModal");
            var modalImage = document.getElementById("modalImage");
            modal.style.display = "flex"; // Menampilkan modal
            modalImage.src = imageSrc; // Set gambar perbesar
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            var modal = document.getElementById("imageModal");
            modal.style.display = "none"; // Menutup modal
        }

        // Menutup modal jika pengguna mengklik di luar gambar
        window.onclick = function(event) {
            var modal = document.getElementById("imageModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
