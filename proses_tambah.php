<?php
include 'koneksi.php';

if (isset($_POST['kd_brg'])) {
    $kd_brg     = trim($_POST['kd_brg']);
    $nama_brg   = trim($_POST['nama_brg']);
    $kategori   = trim($_POST['kategori']);
    $satuan     = trim($_POST['satuan']);
    $harga_jual = trim($_POST['harga_jual']);
    $stok       = trim($_POST['stok']);

    if (empty($kd_brg) || empty($nama_brg)) {
        echo "<script>alert('Kode dan Nama Barang tidak boleh kosong!'); window.location='tambah.php';</script>";
        exit();
    }

    $query = "INSERT INTO barang (kd_brg, nama_brg, kategori, satuan, harga_jual, stok) VALUES ('$kd_brg', '$nama_brg', '$kategori', '$satuan', '$harga_jual', '$stok')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data barang berhasil ditambahkan!'); window.location='barang.php';</script>";
    } else {
        if (mysqli_errno($conn) == 1062) {
            echo "<script>alert('Error: Kode Barang $kd_brg sudah digunakan!'); window.location='tambah.php';</script>";
        } else {
            echo "Gagal menambahkan data: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: barang.php");
    exit();
}
?>