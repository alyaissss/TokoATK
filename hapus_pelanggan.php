<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
if (!$id) {
    header('Location: pelanggan.php');
    exit();
}

$query = mysqli_prepare($conn, "DELETE FROM pelanggan WHERE id_plgn = ?");
mysqli_stmt_bind_param($query, "s", $id);
if (mysqli_stmt_execute($query)) {
    header('Location: pelanggan.php');
    exit();
}

echo "<script>alert('Gagal menghapus pelanggan!'); window.location='pelanggan.php';</script>";
mysqli_stmt_close($query);
mysqli_close($conn);
