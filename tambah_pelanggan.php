<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - ATK Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f3e7d8; display: flex; min-height: 100vh; color: #403127; }
        
        .main-content { flex: 1; padding: 2.5rem; display: flex; justify-content: center; align-items: start; }
        .container { background: #fcf5eb; padding: 2.5rem; border-radius: 12px; border: 1px solid #d3bca4; box-shadow: 0 1px 3px rgba(92,64,51,0.1); width: 100%; max-width: 600px; }
        
        .container h3 { font-size: 1.25rem; font-weight: 700; color: #5b3f2f; margin-bottom: 0.5rem; }
        .form-group { margin-bottom: 1.25rem; display: flex; flex-direction: column; gap: 0.4rem; }
        
        label { font-weight: 500; color: #7b6654; font-size: 0.875rem; }
        input, select, textarea { padding: 0.625rem 0.75rem; border: 1px solid #d3bca4; border-radius: 6px; font-size: 0.9rem; outline: none; transition: all 0.2s; color: #403127; background-color: #fff8f0; }
        input:focus, select:focus, textarea:focus { border-color: #a88665; box-shadow: 0 0 0 3px rgba(168, 134, 101, 0.15); }
        
        .btn-wrapper { display: flex; gap: 10px; margin-top: 1.75rem; }
        .btn { padding: 0.75rem 1.25rem; border-radius: 6px; font-size: 0.9rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; text-align: center; flex: 1; transition: background 0.2s; }
        .btn-submit { background: #6c4d37; color: white; }
        .btn-submit:hover { background: #5a3f31; }
        
        .btn-cancel { background: #fcf5eb; color: #7b6654; border: 1px solid #d3bca4; }
        .btn-cancel:hover { background: #f3e7d8; color: #5b3f2f; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container">
            <h3>➕ Tambah Pelanggan Baru</h3>
            <hr style="margin: 1rem 0 1.5rem; border: 0; border-top: 1px solid #d3bca4;">
            
            <form action="proses_tambah_pelanggan.php" method="POST">
                <div class="form-group">
                    <label>ID Pelanggan</label>
                    <input type="text" name="id_plgn" required placeholder="Contoh: PL001">
                </div>
                <div class="form-group">
                    <label>Nama Pelanggan</label>
                    <input type="text" name="nama_plgn" required placeholder="Masukkan nama pelanggan">
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jk" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" required placeholder="Contoh: 08123456789">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="3" required placeholder="Alamat lengkap"></textarea>
                </div>
                
                <div class="btn-wrapper">
                    <a href="pelanggan.php" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>