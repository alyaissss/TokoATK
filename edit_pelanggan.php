<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
if (!$id) {
    header('Location: pelanggan.php');
    exit();
}

$query = mysqli_prepare($conn, "SELECT * FROM pelanggan WHERE id_plgn = ?");
mysqli_stmt_bind_param($query, "s", $id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data pelanggan tidak ditemukan!'); window.location='pelanggan.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan - ATK Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f3e7d8; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 1.5rem; color: #403127; }
        .form-box { width: 100%; max-width: 540px; padding: 2rem; background: #fcf5eb; border-radius: 14px; border: 1px solid #d3bca4; box-shadow: 0 8px 28px rgba(92,64,51,0.08); }
        h2 { font-size: 1.5rem; color: #5b3f2f; margin-bottom: 1.25rem; text-align: center; }
        .form-group { margin-bottom: 1.25rem; display: flex; flex-direction: column; gap: 0.4rem; }
        label { color: #7b6654; font-weight: 600; font-size: 0.9rem; }
        input, select, textarea { width: 100%; padding: 0.75rem 0.85rem; border: 1px solid #d3bca4; border-radius: 8px; background: #fff8f0; color: #403127; font-size: 0.95rem; outline: none; transition: all 0.2s; }
        input:focus, select:focus, textarea:focus { border-color: #a88665; box-shadow: 0 0 0 3px rgba(168,134,101,0.15); }
        .btn-row { display: flex; gap: 0.85rem; flex-wrap: wrap; margin-top: 1rem; }
        .btn-primary, .btn-secondary { flex: 1; border: none; border-radius: 8px; padding: 0.85rem 1rem; cursor: pointer; font-weight: 700; }
        .btn-primary { background: #6c4d37; color: #fff; }
        .btn-primary:hover { background: #5a3f31; }
        .btn-secondary { background: #fff; color: #5b3f2f; border: 1px solid #d3bca4; }
        .btn-secondary:hover { background: #f3e7d8; }
        .back-link { display: block; text-align: center; margin-top: 1rem; color: #7b6654; text-decoration: none; }
        .back-link:hover { color: #5b3f2f; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Edit Pelanggan</h2>
        <form action="proses_edit_pelanggan.php" method="POST">
            <input type="hidden" name="id_plgn" value="<?= htmlspecialchars($data['id_plgn']); ?>">

            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama_plgn" value="<?= htmlspecialchars($data['nama_plgn']); ?>" required>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jk" required>
                    <option value="L" <?= $data['jk'] === 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= $data['jk'] === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp']); ?>" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="4" required><?= htmlspecialchars($data['alamat']); ?></textarea>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
        <a href="pelanggan.php" class="back-link">← Kembali ke Daftar Pelanggan</a>
    </div>
</body>
</html>
