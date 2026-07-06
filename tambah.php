<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk ATK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f3e7d8; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; color: #403127; }
        
        .form-box { width: 100%; max-width: 480px; padding: 2.5rem; background: #fcf5eb; border-radius: 12px; border: 1px solid #d3bca4; box-shadow: 0 4px 6px -1px rgba(92,64,51,0.12); }
        h2 { font-size: 1.35rem; font-weight: 700; color: #5b3f2f; margin-bottom: 1.5rem; text-align: center; }
        
        .form-group { margin-bottom: 1rem; display: flex; flex-direction: column; gap: 0.4rem; }
        label { font-size: 0.875rem; font-weight: 500; color: #7b6654; }
        
        input, select { width: 100%; padding: 0.625rem 0.75rem; border-radius: 6px; border: 1px solid #d3bca4; font-size: 0.9rem; background-color: #fff8f0; outline: none; transition: all 0.2s; color: #403127; }
        input:focus, select:focus { border-color: #a88665; box-shadow: 0 0 0 3px rgba(168, 134, 101, 0.15); }
        
        .btn-group { display: flex; gap: 10px; margin-top: 1.75rem; }
        button { flex: 1; padding: 0.75rem; background: #6c4d37; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: background 0.2s; }
        button:hover { background: #5a3f31; }
        
        .btn-back { display: block; flex: 1; padding: 0.75rem; background: #fcf5eb; text-decoration: none; text-align: center; border-radius: 6px; color: #7b6654; border: 1px solid #d3bca4; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; }
        .btn-back:hover { background: #f3e7d8; color: #5b3f2f; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Tambah Produk ATK</h2>
    
    <form action="proses_tambah.php" method="POST">
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kd_brg" required placeholder="Contoh: BRG001">
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_brg" required placeholder="Contoh: Buku Sinar Dunia A4">
        </div>
        
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="Kertas">Kertas</option>
                <option value="Alat Tulis">Alat Tulis</option>
                <option value="Buku">Buku</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <select name="satuan" required>
                <option value="Pcs">Pcs</option>
                <option value="Pack">Pack</option>
                <option value="Rim">Rim</option>
                <option value="Box">Box</option>
            </select>
        </div>

        <div class="form-group">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" required placeholder="Contoh: 5000">
        </div>

        <div class="form-group">
            <label>Stok Awal</label>
            <input type="number" name="stok" required placeholder="Contoh: 100">
        </div>

        <div class="btn-group">
            <a href="barang.php" class="btn-back">Kembali</a>
            <button type="submit">Simpan Produk</button>
        </div>
    </form>
</div>

</body>
</html>