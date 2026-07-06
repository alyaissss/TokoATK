<?php
// koneksi.php
$conn = mysqli_connect("localhost", "root", "", "penjualan_atk");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>