<?php
include 'koneksi.php';

$no_nota = isset($_GET['nota']) ? mysqli_real_escape_string($conn, $_GET['nota']) : '';

$query_p = mysqli_query($conn, "SELECT * FROM penjualan WHERE no_nota='$no_nota'");
$penjualan = mysqli_fetch_assoc($query_p);

if (!$penjualan) {
    echo "<script>alert('Nota tidak ditemukan.'); window.location='transaksi.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Resmi #<?php echo htmlspecialchars($no_nota); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #403127; background-color: #f3e7d8; margin: 0; padding: 0; }
        .invoice-box { max-width: 850px; margin: 2rem auto; padding: 2.5rem; border: 1px solid #d3bca4; border-radius: 12px; background: #fcf5eb; box-shadow: 0 4px 6px -1px rgba(92,64,51,0.12); }
        
        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; border-bottom: 1px solid #d3bca4; padding-bottom: 1.5rem; }
        .shop-details h1 { margin: 0 0 0.5rem 0; color: #5b3f2f; font-size: 24px; font-weight: 700; }
        .shop-details p { margin: 0.25rem 0; color: #7b6654; font-size: 0.9rem; }
        .invoice-details { text-align: right; }
        .invoice-details h2 { margin: 0 0 0.5rem 0; color: #6c4d37; font-size: 20px; font-weight: 700; }
        .invoice-details p { margin: 0.25rem 0; font-size: 0.9rem; color: #7b6654; }
        
        .info-table { width: 100%; margin-bottom: 2.5rem; border-collapse: collapse; }
        .info-table td { padding: 0.5rem 0; vertical-align: top; font-size: 0.95rem; }
        .badge-status { color: #5b3f2f; font-weight: 600; background: #f5ead9; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8rem; display: inline-block; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        .items-table th { background-color: #f3e7d8; color: #7b6654; padding: 0.85rem 1rem; text-align: left; font-weight: 600; border-bottom: 2px solid #d3bca4; }
        .items-table td { padding: 1rem; border-bottom: 1px solid #d3bca4; color: #403127; }
        code { background: #f7ead9; padding: 0.2rem 0.4rem; border-radius: 4px; font-family: monospace; font-size: 0.85rem; }
        
        .total-box { float: right; width: 320px; margin-top: 1rem; }
        .total-table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
        .total-table td { padding: 0.5rem 0; color: #7b6654; }
        .total-table tr.grand-total td { font-size: 1.15rem; font-weight: 700; color: #5b3f2f; padding-top: 0.75rem; border-top: 1px solid #d3bca4; }

        .signature-container { margin-top: 12rem; display: flex; justify-content: space-between; clear: both; }
        .signature-box { text-align: center; width: 220px; color: #7b6654; font-size: 0.9rem; }
        .signature-line { margin-top: 5rem; border-top: 1px solid #d3bca4; }

        .no-print { max-width: 850px; margin: 2rem auto 0 auto; display: flex; gap: 0.75rem; padding: 0 1rem; }
        .btn-print { background: #6c4d37; color: white; padding: 0.625rem 1.25rem; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: background 0.2s; }
        .btn-print:hover { background: #5a3f31; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: none; }
            .invoice-box { border: none; padding: 0; margin: 0; max-width: 100%; box-shadow: none; }
            @page { size: A4 portrait; margin: 20mm; }
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">🖨️ Cetak Invoice (A4)</button>
        <a href="transaksi.php" class="btn-print" style="background:#6c4d37;">🛒 Kembali ke Kasir</a>
    </div>

    <div class="invoice-box">
        <div class="invoice-header">
            <div class="shop-details">
                <h1>TOKO ATK JAYA</h1>
                <p>Penyedia Alat Tulis Kantor & Sekolah Terlengkap</p>
                <p>Jl. Raya Pendidikan No. 45, Jakarta</p>
                <p>Telp/WA: 0812-3456-7890</p>
            </div>
            <div class="invoice-details">
                <h2>FAKTUR PENJUALAN</h2>
                <p><strong>No. Nota:</strong> <?php echo htmlspecialchars($penjualan['no_nota']); ?></p>
                <p><strong>Tanggal:</strong> <?php echo date('d F Y H:i', strtotime($penjualan['tgl_transaksi'])); ?></p>
            </div>
        </div>

        <table class="info-table">
            <tr>
                <td style="width: 50%;">
                    <span style="color: #7b6654; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Kepada Yth:</span><br>
                    <div style="margin-top: 0.25rem; font-weight: 600; color: #5b3f2f;">Pelanggan Setia Toko ATK Jaya</div>
                    <div style="color: #7b6654;">Di Tempat</div>
                </td>
                <td class="text-right" style="width: 50%;">
                    <span style="color: #7b6654; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Metode Pembayaran:</span><br>
                    <div style="margin-top: 0.35rem;"><span class="badge-status">LUNAS (Cash)</span></div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 8%;" class="text-center">No</th>
                    <th style="width: 22%;">Kode Barang</th>
                    <th style="width: 40%;">Nama Produk / Item</th>
                    <th style="width: 10%;" class="text-center">Qty</th>
                    <th style="width: 20%;" class="text-right">Harga Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query_d = mysqli_query($conn, "SELECT d.*, b.nama_brg FROM detail_penjualan d JOIN barang b ON d.kd_brg = b.kd_brg WHERE d.no_nota='$no_nota'");
                while ($item = mysqli_fetch_assoc($query_d)) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $no++ . "</td>";
                    echo "<td><code>" . htmlspecialchars($item['kd_brg']) . "</code></td>";
                    echo "<td style='font-weight: 500; color: #5b3f2f;'>" . htmlspecialchars($item['nama_brg']) . "</td>";
                    echo "<td class='text-center'>" . $item['qty'] . "</td>";
                    echo "<td class='text-right'>Rp " . number_format($item['harga_satuan'], 0, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="total-box">
            <table class="total-table">
                <tr>
                    <td>Tunai (Bayar)</td>
                    <td class="text-right">Rp <?php echo number_format($penjualan['uang_bayar'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td class="text-right">Rp <?php echo number_format($penjualan['kembalian'], 0, ',', '.'); ?></td>
                </tr>
                <tr class="grand-total">
                    <td>Total Akhir</td>
                    <td class="text-right" style="color: #6c4d37;">Rp <?php echo number_format($penjualan['total_bayar'], 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>

        <div class="signature-container">
            <div class="signature-box">
                <p>Tanda Terima Pelanggan,</p>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box">
                <p>Hormat Kami (Kasir),</p>
                <div class="signature-line"></div>
            </div>
        </div>
    </div>

</body>
</html>