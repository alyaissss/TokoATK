<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pelanggan.php');
    exit();
}

$id_plgn   = mysqli_real_escape_string($conn, $_POST['id_plgn'] ?? '');
$nama_plgn  = trim(mysqli_real_escape_string($conn, $_POST['nama_plgn'] ?? ''));
$jk         = mysqli_real_escape_string($conn, $_POST['jk'] ?? '');
$no_telp    = mysqli_real_escape_string($conn, $_POST['no_telp'] ?? '');
$alamat     = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');

if (empty($id_plgn) || empty($nama_plgn) || empty($jk)) {
    echo "<script>alert('Nama pelanggan dan jenis kelamin wajib diisi!'); window.location='edit_pelanggan.php?id=" . urlencode($id_plgn) . "';</script>";
    exit();
}

$query = "UPDATE pelanggan SET nama_plgn = ?, jk = ?, no_telp = ?, alamat = ? WHERE id_plgn = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo "Gagal mempersiapkan query: " . mysqli_error($conn);
    exit();
}

mysqli_stmt_bind_param($stmt, "sssss", $nama_plgn, $jk, $no_telp, $alamat, $id_plgn);
if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Data pelanggan berhasil diperbarui!'); window.location='pelanggan.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui data pelanggan.'); window.location='pelanggan.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>