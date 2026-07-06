<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: transaksi.php");
    exit();
}

$id_plgn        = $_POST['id_plgn'] ?? '';
$data_keranjang = $_POST['data_keranjang'] ?? '';
$tgl_transaksi  = date('Y-m-d H:i:s');
$uang_bayar = $_POST['uang_bayar'] ?? $total_bayar; 
$kembalian  = $uang_bayar - $total_bayar;

$data_array = json_decode($data_keranjang, true);

if (!is_array($data_array) || count($data_array) === 0) {
    echo "<script>alert('Keranjang belanja masih kosong!'); window.location='transaksi.php';</script>";
    exit();
}

$total_bayar = 0;
foreach ($data_array as $item) {
    $total_bayar += $item['subtotal'];
}

$uang_bayar = $_POST['uang_bayar'] ?? $total_bayar; 
$kembalian  = $uang_bayar - $total_bayar;
$no_nota = "NOTA-" . date('YmdHis');

mysqli_begin_transaction($conn);

try {
    $query_sales = "INSERT INTO penjualan (no_nota, tgl_transaksi, total_bayar, uang_bayar, kembalian) VALUES (?, ?, ?, ?, ?)";
    $stmt_sales = mysqli_prepare($conn, $query_sales);
    mysqli_stmt_bind_param($stmt_sales, "ssddd", $no_nota, $tgl_transaksi, $total_bayar, $uang_bayar, $kembalian);
    mysqli_stmt_execute($stmt_sales);

    $query_detail = "INSERT INTO detail_penjualan (no_nota, kd_brg, qty, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)";
    $stmt_detail = mysqli_prepare($conn, $query_detail);

    $query_stok = "UPDATE barang SET stok = stok - ? WHERE kd_brg = ? AND stok >= ?";
    $stmt_stok = mysqli_prepare($conn, $query_stok);

    foreach ($data_array as $item) {
        $kd_brg       = $item['kd_brg'];
        $qty          = $item['qty'];
        $harga_satuan = $item['harga_jual'];
        $subtotal     = $item['subtotal'];

        mysqli_stmt_bind_param($stmt_detail, "ssidd", $no_nota, $kd_brg, $qty, $harga_satuan, $subtotal);
        mysqli_stmt_execute($stmt_detail);

        mysqli_stmt_bind_param($stmt_stok, "isi", $qty, $kd_brg, $qty);
        mysqli_stmt_execute($stmt_stok);
    }

    mysqli_commit($conn);
    echo "<script>alert('Transaksi Berhasil Disimpan!'); window.location='cetak_nota.php?nota=$no_nota';</script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Transaksi Gagal.'); window.location='transaksi.php';</script>";
}
?>