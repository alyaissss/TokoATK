<?php
// transaksi.php
session_start();
include 'koneksi.php';

// Proteksi halaman
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}

// Ambil data pelanggan untuk dropdown kasir
$pelanggan_query = mysqli_query($conn, "SELECT id_plgn, nama_plgn FROM pelanggan");

// Ambil data barang untuk pilihan item
$barang_query = mysqli_query($conn, "SELECT kd_brg, nama_brg, harga_jual, stok FROM barang WHERE stok > 0");
$barang_data = [];
while ($b = mysqli_fetch_assoc($barang_query)) {
    $barang_data[$b['kd_brg']] = $b;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f3e7d8; display: flex; min-height: 100vh; color: #403127; }
        
        /* Main Layout */
        .main-content { flex: 1; padding: 2.5rem; display: flex; flex-direction: column; gap: 2rem; }
        .header { background: #fcf5eb; padding: 1.25rem 2rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #d3bca4; box-shadow: 0 1px 3px rgba(92,64,51,0.1); }
        .header h2 { font-size: 1.25rem; font-weight: 700; color: #5b3f2f; }
        
        .container { background: #fcf5eb; padding: 2rem; border-radius: 12px; border: 1px solid #d3bca4; box-shadow: 0 1px 3px rgba(92,64,51,0.1); }
        .container h3 { font-size: 1.1rem; font-weight: 700; color: #5b3f2f; }
        
        /* Forms & Inputs */
        .form-group { margin-bottom: 1.25rem; display: flex; flex-direction: column; gap: 0.4rem; }
        .form-row { display: flex; gap: 15px; margin-bottom: 1.25rem; }
        .form-row .form-group { flex: 1; margin-bottom: 0; }
        label { font-weight: 500; color: #7b6654; font-size: 0.875rem; }
        select, input { padding: 0.625rem 0.75rem; border: 1px solid #d3bca4; border-radius: 6px; font-size: 0.9rem; width: 100%; outline: none; transition: all 0.2s; color: #403127; background-color: #fff8f0; }
        select:focus, input:focus { border-color: #a88665; box-shadow: 0 0 0 3px rgba(168, 134, 101, 0.15); }
        
        /* Grid Layout untuk Kasir */
        .grid-transaksi { display: grid; grid-template-columns: 1fr 1.3fr; gap: 2rem; }
        
        /* Buttons */
        .btn { padding: 0.625rem 1.25rem; text-decoration: none; border-radius: 6px; color: white; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background 0.2s; border: none; cursor: pointer; text-align: center; }
        .btn-add-item { background: #6c4d37; width: 100%; margin-top: 0.5rem; }
        .btn-add-item:hover { background: #5a3f31; }
        .btn-checkout { background: #4a6d45; width: 100%; font-size: 1rem; padding: 0.875rem; margin-top: 1.5rem; }
        .btn-checkout:hover { background: #405a3a; }
        .btn-danger { background: #fcf5eb; color: #9c5846; border: 1px solid #e5c9ba; padding: 0.35rem 0.65rem; font-size: 0.8rem; border-radius: 4px; }
        .btn-danger:hover { background: #f3e7d8; }
        
        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.9rem; }
        th, td { border-bottom: 1px solid #d3bca4; padding: 1rem; text-align: left; }
        th { background-color: #f3e7d8; color: #7b6654; font-weight: 600; }
        
        .total-box { background: #f3e7d8; padding: 1.25rem; border-radius: 8px; border: 1px dashed #d3bca4; margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .total-price { font-size: 1.5rem; font-weight: 700; color: #5b3f2f; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="header">
        <h2>💰 Transaksi Penjualan</h2>
    </div>

    <form action="proses_transaksi.php" method="POST" id="form-transaksi">
        <div class="grid-transaksi">
            
            <!-- SISI KIRI: INPUT UTAMA & BARANG -->
            <div class="container">
                <h3>Detail Nota</h3>
                <hr style="margin: 1rem 0 1.25rem; border: 0; border-top: 1px solid #d3bca4;">
                
                <div class="form-group">
                    <label>Pilih Pelanggan</label>
                    <select name="id_plgn" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php while($p = mysqli_fetch_assoc($pelanggan_query)) { ?>
                            <option value="<?= $p['id_plgn']; ?>"><?= htmlspecialchars($p['nama_plgn']); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" style="margin-top: 2rem;">
                    <h3>Pilih Produk</h3>
                    <hr style="margin: 0.75rem 0; border: 0; border-top: 1px solid #d3bca4;">
                </div>

                <div class="form-group">
                    <label>Nama Barang</label>
                    <select id="pilih-barang" onchange="updateDetailBarang()">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach($barang_data as $kd => $b) { ?>
                            <option value="<?= $kd; ?>"><?= htmlspecialchars($b['nama_brg']); ?> (Stok: <?= $b['stok']; ?>)</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga Satuan</label>
                        <input type="text" id="harga-barang" readonly style="background: #fff8f0; color: #7b6654;">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Beli</label>
                        <input type="number" id="jumlah-barang" min="1" value="1">
                    </div>
                </div>

                <button type="button" class="btn btn-add-item" onclick="tambahKeKeranjang()">Masukkan Keranjang</button>
            </div>

            <!-- SISI KANAN: KERANJANG BELANJA -->
            <div class="container" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 480px;">
                <div>
                    <h3>Keranjang Belanja</h3>
                    <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #d3bca4;">
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th style="width: 60px; text-align: center;">Qty</th>
                                <th>Subtotal</th>
                                <th style="width: 70px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="isi-keranjang">
                            <tr id="keranjang-kosong">
                                <td colspan="5" style="text-align: center; color: #7b6654; padding: 2rem;">Belum ada barang di keranjang.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div>
                    <div class="total-box">
                        <span style="font-size: 0.875rem; font-weight: 500; color: #7b6654;">Total Belanja:</span>
                        <div class="total-price" id="label-total">Rp 0</div>
                    </div>

                    <!-- INPUT NOMINAL UANG PEMBELI -->
                    <div class="form-group" style="margin-top: 1rem;">
                        <label>Uang Bayar (Rp)</label>
                        <input type="number" name="uang_bayar" id="uang-bayar" min="0" placeholder="Masukkan nominal uang..." oninput="hitungKembalian()" required>
                    </div>

                    <!-- BOX HASIL KEMBALIAN -->
                    <div class="total-box" style="margin-top: 1rem; background: #f3e7d8; border-color: #d3bca4;">
                        <span style="font-size: 0.875rem; font-weight: 500; color: #6c4d37;">Kembalian:</span>
                        <div class="total-price" id="label-kembalian" style="color: #4a6d45;">Rp 0</div>
                    </div>
                    
                    <input type="hidden" name="data_keranjang" id="data-keranjang-input">
                    <button type="submit" class="btn btn-checkout" onclick="return validasiCheckout()">Selesaikan Transaksi</button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
const masterBarang = <?= json_encode($barang_data); ?>;
let keranjang = [];
let totalBelanja = 0; // Variabel global untuk menyimpan total belanjaan saat ini

function updateDetailBarang() {
    const kdBrg = document.getElementById('pilih-barang').value;
    if(kdBrg && masterBarang[kdBrg]) {
        document.getElementById('harga-barang').value = "Rp " + parseInt(masterBarang[kdBrg].harga_jual).toLocaleString('id-ID');
    } else {
        document.getElementById('harga-barang').value = "";
    }
}

function tambahKeKeranjang() {
    const selector = document.getElementById('pilih-barang');
    const kdBrg = selector.value;
    const qty = parseInt(document.getElementById('jumlah-barang').value);

    if(!kdBrg) {
        alert('Silakan pilih barang terlebih dahulu!');
        return;
    }

    if(qty <= 0 || isNaN(qty)) {
        alert('Jumlah beli tidak valid!');
        return;
    }

    const barang = masterBarang[kdBrg];
    const itemEksis = keranjang.find(item => item.kd_brg === kdBrg);
    const qtyTotal = (itemEksis ? itemEksis.qty : 0) + qty;

    if(qtyTotal > parseInt(barang.stok)) {
        alert(`Stok tidak mencukupi! Stok tersedia: ${barang.stok}`);
        return;
    }

    if(itemEksis) {
        itemEksis.qty = qtyTotal;
        itemEksis.subtotal = itemEksis.qty * barang.harga_jual;
    } else {
        keranjang.push({
            kd_brg: kdBrg,
            nama_brg: barang.nama_brg,
            harga_jual: parseInt(barang.harga_jual),
            qty: qty,
            subtotal: qty * parseInt(barang.harga_jual)
        });
    }

    selector.value = "";
    document.getElementById('harga-barang').value = "";
    document.getElementById('jumlah-barang').value = 1;

    renderKeranjang();
}

function hapusItem(kdBrg) {
    keranjang = keranjang.filter(item => item.kd_brg !== kdBrg);
    renderKeranjang();
}

function renderKeranjang() {
    const tbody = document.getElementById('isi-keranjang');
    tbody.innerHTML = "";

    if(keranjang.length === 0) {
        tbody.innerHTML = `<tr id="keranjang-kosong"><td colspan="5" style="text-align: center; color: #7b6654; padding: 2rem;">Belum ada barang di keranjang.</td></tr>`;
        document.getElementById('label-total').innerText = "Rp 0";
        document.getElementById('data-keranjang-input').value = "";
        totalBelanja = 0;
        hitungKembalian();
        return;
    }

    let total = 0;
    keranjang.forEach(item => {
        total += item.subtotal;
        tbody.innerHTML += `
            <tr>
                <td style="font-weight: 500; color: #5b3f2f;">${item.nama_brg}</td>
                <td style="color: #7b6654;">Rp ${item.harga_jual.toLocaleString('id-ID')}</td>
                <td style="text-align: center; color: #5b3f2f; font-weight: 600;">${item.qty}</td>
                <td style="font-weight: 600; color: #5b3f2f;">Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                <td style="text-align: center;"><button type="button" class="btn btn-danger" onclick="hapusItem('${item.kd_brg}')">Hapus</button></td>
            </tr>`;
    });

    totalBelanja = total;
    document.getElementById('label-total').innerText = "Rp " + total.toLocaleString('id-ID');
    document.getElementById('data-keranjang-input').value = JSON.stringify(keranjang);
    
    hitungKembalian(); // Hitung ulang kembalian setiap kali keranjang diubah
}

// Menghitung kembalian secara real-time
function hitungKembalian() {
    const uangBayarInput = document.getElementById('uang-bayar').value;
    const uangBayar = parseInt(uangBayarInput) || 0;
    
    let kembalian = uangBayar - totalBelanja;
    const labelKembalian = document.getElementById('label-kembalian');
    
    if (kembalian < 0) {
        labelKembalian.innerText = "Uang Kurang!";
        labelKembalian.style.color = "#9c5846";
    } else {
        labelKembalian.innerText = "Rp " + kembalian.toLocaleString('id-ID');
        labelKembalian.style.color = "#4a6d45";
    }
}

function validasiCheckout() {
    if(keranjang.length === 0) {
        alert('Keranjang belanja masih kosong!');
        return false;
    }
    
    const uangBayar = parseInt(document.getElementById('uang-bayar').value) || 0;
    if(uangBayar < totalBelanja) {
        alert('Mohon maaf, nominal uang bayar kurang dari total belanja!');
        return false;
    }
    
    return confirm('Apakah data transaksi sudah benar dan siap disimpan?');
}
</script>

</body>
</html>