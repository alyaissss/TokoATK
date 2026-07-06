<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM barang WHERE kd_brg='$id'";

if(mysqli_query($conn, $query)) {
    header("Location: barang.php");
} else {
    echo "Gagal menghapus data!";
}
?>