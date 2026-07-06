<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM barang");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - ATK Store</title>
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
        .container h3 { font-size: 1.25rem; font-weight: 700; color: #5b3f2f; margin-bottom: 0.5rem; }
        
        .btn { padding: 0.625rem 1.25rem; text-decoration: none; border-radius: 6px; color: white; font-weight: 600; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s; border: none; cursor: pointer; }
        .btn-add { background: #6c4d37; }
        .btn-add:hover { background: #5a3f31; }
        .btn-print { background: #4a6d45; }
        .btn-print:hover { background: #405a3a; }
        .btn-logout { background: #9c5846; }
        .btn-logout:hover { background: #7d4035; }
        
        .btn-edit { background: #fff; color: #6c4d37; border: 1px solid #d4b184; padding: 0.375rem 0.75rem; font-size: 0.825rem; border-radius: 4px; font-weight: 500; }
        .btn-edit:hover { background: #f5ead9; }
        .btn-delete { background: #fff; color: #9c5846; border: 1px solid #e5c9ba; padding: 0.375rem 0.75rem; font-size: 0.825rem; border-radius: 4px; font-weight: 500; }
        .btn-delete:hover { background: #f8f0e8; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; font-size: 0.925rem; }
        th, td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid #d3bca4; }
        th { background-color: #f3e7d8; color: #7b6654; font-weight: 600; }
        tr:hover td { background-color: #f5ead9; }
        code { background: #f7ebda; padding: 0.2rem 0.4rem; border-radius: 4px; font-size: 0.85rem; color: #5b3f2f; font-family: monospace; }
        
        @media print {
            .sidebar, .header, .btn-add, .btn-print, .no-print, th:last-child, td:last-child { display: none !important; }
            body { background-color: #fff; }
            .main-content, .container { padding: 0; box-shadow: none; border: none; }
            th { background-color: #f7ead9 !important; color: #5b3f2f !important; border: 1px solid #d3bca4; }
            td { border: 1px solid #d3bca4; }
            .print-title { display: block !important; text-align: center; margin-bottom: 2rem; }
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="header">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama_user']); ?>!</h2>
    </div>

    <div class="container">
        <div class="print-title" style="display: none;">
            <h2>LAPORAN STOK BARANG TOKO ATK JAYA</h2>
            <p>Tanggal Cetak: <?php echo date('d-m-Y'); ?></p>
            <hr style="margin-top: 15px; border: 1px solid #6c4d37;">
        </div>
        <h3>📦 Daftar Produk ATK</h3>
        <div class="no-print" style="margin-top: 1rem; display: flex; gap: 0.75rem;">
            <a href="tambah.php" class="btn btn-add">Tambah Produk Baru</a>
            <button onclick="window.print()" class="btn btn-print">Cetak Laporan Barang</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th class="no-print" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><code><?php echo htmlspecialchars($row['kd_brg']); ?></code></td>
                    <td style="font-weight: 500; color: #5b3f2f;"><?php echo htmlspecialchars($row['nama_brg']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td><?php echo htmlspecialchars($row['satuan']); ?></td>
                    <td>Rp <?php echo number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                    <td style="font-weight: 600;"><?php echo $row['stok']; ?></td>
                    <td class="no-print">
                        <div style="display: flex; gap: 0.25rem;">
                            <a href="edit.php?id=<?php echo urlencode($row['kd_brg']); ?>" class="btn btn-edit">Edit</a>
                            <a href="hapus.php?id=<?php echo urlencode($row['kd_brg']); ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>