<?php
// penjualan.php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}

// Ambil semua data ringkasan penjualan
$query = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY tgl_transaksi DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penjualan - ATK Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f3e7d8; color: #403127; display: flex; min-height: 100vh; }
        
        .main-content { flex: 1; padding: 2.5rem; display: flex; flex-direction: column; gap: 2rem; }
        .header { background: #fcf5eb; padding: 1.25rem 2rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #d3bca4; box-shadow: 0 1px 3px rgba(92,64,51,0.1); }
        .header h2 { font-size: 1.25rem; font-weight: 700; color: #5b3f2f; }
        
        .container { background: #fcf5eb; padding: 2rem; border-radius: 12px; border: 1px solid #d3bca4; box-shadow: 0 1px 3px rgba(92,64,51,0.1); }
        .container h3 { font-size: 1.25rem; font-weight: 700; color: #5b3f2f; margin-bottom: 1rem; }
        
        table { width: 100%; border-collapse: collapse; font-size: 0.925rem; }
        th, td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid #d3bca4; }
        th { background-color: #f3e7d8; color: #7b6654; font-weight: 600; }
        tr:hover td { background-color: #f5ead9; }
        
        .btn { padding: 0.45rem 0.85rem; text-decoration: none; border-radius: 6px; font-size: 0.825rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s; }
        .btn-info { background: #fff; color: #6c4d37; border: 1px solid #d4b184; }
        .btn-info:hover { background: #f5ead9; }
        .btn-print { background: #fff; color: #4a6d45; border: 1px solid #c9bea9; margin-left: 5px; }
        .btn-print:hover { background: #f2e8d9; }
        .text-right { text-align: right; }
        
        .badge-nota { background: #f7ead9; padding: 0.25rem 0.5rem; border-radius: 4px; font-family: monospace; font-size: 0.85rem; color: #5b3f2f; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="header">
        <h2>Laporan & Riwayat Penjualan</h2>
    </div>

    <div class="container">
        <h3>Daftar Nota Masuk</h3>
        <table>
            <thead>
                <tr>
                    <th>No. Nota</th>
                    <th>Tanggal Transaksi</th>
                    <th class="text-right">Total Belanja</th>
                    <th class="text-right">Uang Bayar</th>
                    <th class="text-right">Kembalian</th>
                    <th style="width: 200px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($query) == 0) {
                    echo "<tr><td colspan='6' style='text-align:center; color:#7b6654; padding: 2rem;'>Belum ada data transaksi masuk.</td></tr>";
                }
                while($row = mysqli_fetch_assoc($query)) { 
                ?>
                <tr>
                    <td><span class="badge-nota"><?= htmlspecialchars($row['no_nota']); ?></span></td>
                    <td style="color: #7b6654;"><?= date('d M Y H:i', strtotime($row['tgl_transaksi'])); ?></td>
                    <td class="text-right" style="font-weight: 600; color: #5b3f2f;">Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                    <td class="text-right" style="color: #7b6654;">Rp <?= number_format($row['uang_bayar'], 0, ',', '.'); ?></td>
                    <td class="text-right" style="color: #7b6654;">Rp <?= number_format($row['kembalian'], 0, ',', '.'); ?></td>
                    <td style="text-align: center;">
                        <a href="detail_penjualan.php?nota=<?= urlencode($row['no_nota']); ?>" class="btn btn-info">Detail</a>
                        <a href="cetak_nota.php?nota=<?= urlencode($row['no_nota']); ?>" target="_blank" class="btn btn-print">Cetak</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>