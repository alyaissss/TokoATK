<?php
include 'koneksi.php';

$id_plgn = mysqli_real_escape_string($conn, $_POST['id_plgn']);
$nama_plgn = mysqli_real_escape_string($conn, $_POST['nama_plgn']);
$jk        = mysqli_real_escape_string($conn, $_POST['jk']);
$no_telp   = mysqli_real_escape_string($conn, $_POST['no_telp']);
$alamat    = mysqli_real_escape_string($conn, $_POST['alamat']);

$query = "INSERT INTO pelanggan (id_plgn, nama_plgn, jk, no_telp, alamat) VALUES ('$id_plgn', '$nama_plgn', '$jk', '$no_telp', '$alamat')";

if(mysqli_query($conn, $query)) {
    header("Location: pelanggan.php");
} else {
    echo "Gagal menambahkan pelanggan: " . mysqli_error($conn);
}
?>