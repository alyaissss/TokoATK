<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_barang  = $_POST['id_barang'];
    $nama_brg   = trim($_POST['nama_brg']);
    $kategori   = $_POST['kategori'];
    $harga_jual = $_POST['harga'];
    $stok       = $_POST['stok'];

    if (empty($id_barang) || empty($nama_brg)) {
        echo "<script>alert('Data tidak boleh kosong!'); window.location='barang.php';</script>";
        exit();
    }

    $query = "UPDATE barang SET nama_brg = ?, kategori = ?, harga_jual = ?, stok = ? WHERE kd_brg = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssdis", $nama_brg, $kategori, $harga_jual, $stok, $id_barang);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data barang berhasil diperbarui!'); window.location='barang.php';</script>";
        } else {
            echo "Gagal mengeksekusi perubahan: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
} else {
    header("Location: barang.php");
    exit();
}
?>