<?php
session_start();
include 'koneksi.php';

$no_nota = isset($_GET['nota']) ? mysqli_real_escape_string($conn, $_GET['nota']) : '';

$query_p = mysqli_query($conn, "SELECT * FROM penjualan WHERE no_nota = '$no_nota'");
$penjualan = mysqli_fetch_assoc($query_p);

if(!$penjualan) {
    echo "<script>alert('Nota tidak ditemukan!'); window.location='penjualan.php';</script>";
    exit();
}

$query_d = mysqli_query($conn, "SELECT d.*, b.nama_brg FROM detail_penjualan d 
                                JOIN barang b ON d.kd_brg = b.kd_brg 
                                WHERE d.no_nota = '$no_nota'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Nota #<?= htmlspecialchars($no_nota); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f3e7d8; color: #403127; display: flex; min-height: 100vh; }
        
        .main-content { flex: 1; padding: 2.5rem; display: flex; flex-direction: column; gap: 2rem; }
        .container { background: #fcf5eb; padding: 2rem; border-radius: 12px; border: 1px solid #d3bca4; box-shadow: 0 1px 3px rgba(92,64,51,0.1); }
        .container h2 { font-size: 1.5rem; font-weight: 700; color: #5b3f2f; margin-bottom: 1.5rem; }
        
        .meta-nota { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f3e7d8; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #6c4d37; border-top: 1px solid #d3bca4; border-right: 1px solid #d3bca4; border-bottom: 1px solid #d3bca4; }
        .meta-nota p { font-size: 0.95rem; color: #7b6654; margin-bottom: 0.5rem; }
        .meta-nota p:last-child { margin-bottom: 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.925rem; }
        th, td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid #d3bca4; }
        th { background-color: #f3e7d8; color: #7b6654; font-weight: 600; }
        .text-right { text-align: right; }
        code { background: #f7ead9; padding: 0.2rem 0.4rem; border-radius: 4px; font-family: monospace; font-size: 0.85rem; }
        
        .btn-back { background: #6c4d37; color: white; padding: 0.625rem 1.25rem; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 0.875rem; font-weight: 600; transition: background 0.2s; margin-top: 1.5rem; }
        .btn-back:hover { background: #5a3f31; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container">
        <h2>📄 Rincian Transaksi</h2>

        <div class="meta-nota">
            <div>
                <p><strong>Nomor Nota :</strong> <?= htmlspecialchars($penjualan['no_nota']); ?></p>
                <p><strong>Waktu Belanja :</strong> <?= date('d F Y H:i:s', strtotime($penjualan['tgl_transaksi'])); ?></p>
            </div>
            <div class="text-right">
                <p>Total Tagihan: <span style="font-size: 22px; color:#5b3f2f; font-weight:700;">Rp <?= number_format($penjualan['total_bayar'], 0, ',', '.'); ?></span></p>
                <p>Tunai: Rp <?= number_format($penjualan['uang_bayar'], 0, ',', '.'); ?> | Kembali: Rp <?= number_format($penjualan['kembalian'], 0, ',', '.'); ?></p>
            </div>
        </div>

        <h3 style="font-size: 1.15rem; font-weight: 600; color: #5b3f2f;">📦 Item yang Dibeli</h3>
        <table>
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk / ATK</th>
                    <th class="text-right">Harga Satuan</th>
                    <th style="text-align: center;">Kuantitas (Qty)</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($query_d)) { ?>
                <tr>
                    <td><code><?= htmlspecialchars($item['kd_brg']); ?></code></td>
                    <td style="font-weight: 500; color: #5b3f2f;"><?= htmlspecialchars($item['nama_brg']); ?></td>
                    <td class="text-right">Rp <?= number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
                    <td style="text-align: center;"><?= $item['qty']; ?> pcs</td>
                    <td class="text-right" style="color: #5b3f2f; font-weight: 600;">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="penjualan.php" class="btn-back">← Kembali ke Riwayat Penjualan</a>
    </div>
</div>

</body>
</html>