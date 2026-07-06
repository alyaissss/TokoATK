<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM pelanggan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - ATK Store</title>
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

        /* Desain Tombol Aksi */
        .btn-action { padding: 0.35rem 0.65rem; font-size: 0.8rem; border-radius: 4px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; transition: all 0.2s; }
        .btn-edit { background: #fff; color: #6c4d37; border: 1px solid #d4b184; }
        .btn-edit:hover { background: #f5ead9; }
        .btn-delete { background: #fff; color: #9c5846; border: 1px solid #e5c9ba; }
        .btn-delete:hover { background: #f8f0e8; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; font-size: 0.925rem; }
        th, td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid #d3bca4; }
        th { background-color: #f3e7d8; color: #7b6654; font-weight: 600; }
        tr:hover td { background-color: #f5ead9; }
        
        @media print {
            .sidebar, .header, .btn-add, .btn-print, .no-print, .col-action { display: none !important; }
            body { background-color: white; }
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
            <h2>LAPORAN DATA PELANGGAN TOKO ATK JAYA</h2>
            <p>Tanggal Cetak: <?php echo date('d-m-Y'); ?></p>
            <hr style="margin-top: 15px; border: 1px solid #6c4d37;">
        </div>

        <h3>👥 Daftar Pelanggan Toko</h3>
        
        <div class="no-print" style="margin-top: 1rem; display: flex; gap: 0.75rem;">
            <a href="tambah_pelanggan.php" class="btn btn-add">Tambah Pelanggan Baru</a>
            <button onclick="window.print()" class="btn btn-print">Cetak Laporan Pelanggan</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th>Nama Pelanggan</th>
                    <th>Jenis Kelamin</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
                    <th class="col-action" style="width: 18%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td style="font-weight: 500; color: #5b3f2f;"><?php echo htmlspecialchars($row['nama_plgn']); ?></td>
                    <td><?php echo ($row['jk'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                    <td><?php echo htmlspecialchars($row['no_telp']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td class="col-action" style="text-align: center;">
                        <!-- Tombol Edit dengan Parameter ID -->
                        <a href="edit_pelanggan.php?id=<?php echo urlencode($row['id_plgn']); ?>" class="btn-action btn-edit">Edit</a>
                        <!-- Tombol Hapus dengan Parameter ID dan Konfirmasi Pop-up -->
                        <a href="hapus_pelanggan.php?id=<?php echo urlencode($row['id_plgn']); ?>" 
                           class="btn-action btn-delete" 
                           onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan <?php echo addslashes(htmlspecialchars($row['nama_plgn'])); ?>?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>