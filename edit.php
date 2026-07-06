<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

$query = mysqli_prepare($conn, "SELECT * FROM barang WHERE kd_brg = ?");
mysqli_stmt_bind_param($query, "s", $id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data barang tidak ditemukan!'); window.location='barang.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk ATK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f3e7d8; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 1.5rem; }
        .form-box { width: 100%; max-width: 440px; padding: 2rem; background: #fcf5eb; border-radius: 12px; color: #403127; border: 1px solid #d3bca4; box-shadow: 0 4px 6px -1px rgba(92,64,51,0.12); }
        .form-box h2 { font-size: 1.35rem; font-weight: 700; color: #5b3f2f; margin-bottom: 1.5rem; text-align: center; }
        
        label { display: block; font-size: 0.875rem; font-weight: 500; color: #7b6654; margin-bottom: 0.4rem; margin-top: 1rem; }
        input, select { width: 100%; padding: 0.625rem 0.75rem; font-size: 0.9rem; border-radius: 6px; border: 1px solid #d3bca4; background-color: #fff8f0; color: #403127; outline: none; transition: border-color 0.2s; }
        input:focus, select:focus { border-color: #a88665; box-shadow: 0 0 0 3px rgba(168,134,101,0.15); }
        
        button { width: 100%; padding: 0.75rem; background: #6c4d37; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem; margin-top: 1.5rem; transition: background 0.2s; }
        button:hover { background: #5a3f31; }
        
        .back-link { display: block; text-align: center; margin-top: 1.25rem; color: #7b6654; text-decoration: none; font-size: 0.875rem; font-weight: 500; }
        .back-link:hover { color: #5b3f2f; text-decoration: underline; }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Edit Produk ATK</h2>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id_barang" value="<?php echo htmlspecialchars($data['kd_brg']); ?>">

        <label>Nama Barang</label>
        <input type="text" name="nama_brg" value="<?php echo htmlspecialchars($data['nama_brg']); ?>" required>
        
        <label>Kategori</label>
        <select name="kategori">
            <option value="Kertas" <?php if($data['kategori'] == 'Kertas') echo 'selected'; ?>>Kertas</option>
            <option value="Alat Tulis" <?php if($data['kategori'] == 'Alat Tulis') echo 'selected'; ?>>Alat Tulis</option>
            <option value="Buku" <?php if($data['kategori'] == 'Buku') echo 'selected'; ?>>Buku</option>
            <option value="Lainnya" <?php if($data['kategori'] == 'Lainnya') echo 'selected'; ?>>Lainnya</option>
        </select>

        <label>Harga Jual (Rp)</label>
        <input type="number" name="harga" value="<?php echo htmlspecialchars($data['harga_jual'] ?? $data['harga']); ?>" required>

        <label>Stok Ketersediaan</label>
        <input type="number" name="stok" value="<?php echo htmlspecialchars($data['stok']); ?>" required>

        <button type="submit">Update Produk</button>
        <a href="barang.php" class="back-link">← Kembali ke Data Barang</a>
    </form>
</div>
</body>
</html>