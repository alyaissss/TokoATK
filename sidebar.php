<?php
// sidebar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    .sidebar { 
        width: 260px; 
        background-color: #5b3f2f; 
        color: #f5e8db; 
        padding: 2rem 1.5rem; 
        display: flex; 
        flex-direction: column; 
        justify-content: space-between; /* Membuat konten terpisah ke atas dan paling bawah */
        height: 100vh; /* Mengunci tinggi agar pas dengan layar */
        position: sticky;
        top: 0;
        border-right: 1px solid #6c4d37;
    }
    .sidebar-brand { 
        font-size: 1.15rem; 
        font-weight: 700; 
        margin-bottom: 2.5rem; 
        text-align: left; 
        padding-bottom: 1rem; 
        color: #fff3e8; 
        letter-spacing: -0.5px;
        border-bottom: 1px solid #6c4d37;
    }
    .sidebar-menu { 
        list-style: none; 
        display: flex; 
        flex-direction: column; 
        gap: 0.5rem;
    }
    .sidebar-menu li a { 
        display: block; 
        padding: 0.75rem 1rem; 
        color: #f5e8db; 
        text-decoration: none; 
        border-radius: 8px; 
        font-weight: 500; 
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .sidebar-menu li a:hover {
        background-color: #6c4d37;
        color: #fff3e8;
    }
    .sidebar-menu li.active a { 
        background-color: #d4b184; 
        color: #5b3f2f; 
        font-weight: 600;
    }
    
    /* GAYA BARU: Untuk penempatan log out di paling bawah */
    .sidebar-footer {
        border-top: 1px solid #6c4d37;
        padding-top: 1.5rem;
    }
    .btn-logout-sidebar {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: #f5e8db !important; /* Warna merah teks */
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .btn-logout-sidebar:hover {
        background-color: rgba(220, 172, 129, 0.18);
    }
</style>

<div class="sidebar">
    <!-- Bagian Atas: Menu Utama -->
    <div>
        <div class="sidebar-brand">
            TOKO ATK JAYA
        </div>
        <ul class="sidebar-menu">
            <li class="<?php echo ($current_page == 'barang.php') ? 'active' : ''; ?>">
                <a href="barang.php">Data Produk</a>
            </li>
            <li class="<?php echo ($current_page == 'pelanggan.php') ? 'active' : ''; ?>">
                <a href="pelanggan.php">Data Pelanggan</a>
            </li>
            <li class="<?php echo ($current_page == 'penjualan.php') ? 'active' : ''; ?>">
                <a href="penjualan.php">Data Penjualan</a>
            </li>
            <li class="<?php echo ($current_page == 'transaksi.php') ? 'active' : ''; ?>">
                <a href="transaksi.php">Transaksi</a>
            </li>
        </ul>
    </div>

    <!-- Bagian Bawah: Tombol Keluar Aplikasi -->
    <div class="sidebar-footer">
        <a href="logout.php" class="btn-logout-sidebar" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
            Log Out
        </a>
    </div>
</div>