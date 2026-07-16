    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-shop"></i></div>
            <span>Ketoeroenan <span style="color:#818cf8">Doeloe</span></span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-title">Menu Utama</div>
            <a href="<?= BASE_URL ?>/modules/dashboard/index.php" class="nav-item <?= $currentDir=='dashboard'?'active':'' ?>">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            
            <?php if (in_array($user['role'], ['admin', 'kasir'])): ?>
            <a href="<?= BASE_URL ?>/modules/penjualan/kasir.php" class="nav-item <?= $currentPage=='kasir'?'active':'' ?>">
                <i class="bi bi-cart3"></i><span>Kasir / POS</span>
            </a>
            <?php endif; ?>

            <div class="nav-section-title">Manajemen</div>
            
            <?php if (in_array($user['role'], ['admin', 'gudang'])): ?>
            <a href="<?= BASE_URL ?>/modules/produk/index.php" class="nav-item <?= $currentDir=='produk'?'active':'' ?>">
                <i class="bi bi-box-seam"></i><span>Produk</span>
            </a>
            <a href="<?= BASE_URL ?>/modules/kategori/index.php" class="nav-item <?= $currentDir=='kategori'?'active':'' ?>">
                <i class="bi bi-tags"></i><span>Kategori</span>
            </a>
            <a href="<?= BASE_URL ?>/modules/stok/index.php" class="nav-item <?= $currentDir=='stok'&&$currentPage=='index'?'active':'' ?>">
                <i class="bi bi-archive"></i><span>Stok Inventaris</span>
                <?php if($lowStockCount>0): ?><span class="nav-badge"><?= $lowStockCount ?></span><?php endif; ?>
            </a>
            <a href="<?= BASE_URL ?>/modules/stok/masuk.php" class="nav-item <?= $currentPage=='masuk'&&$currentDir=='stok'?'active':'' ?>">
                <i class="bi bi-box-arrow-in-down"></i><span>Barang Masuk</span>
            </a>
            <a href="<?= BASE_URL ?>/modules/stok/keluar.php" class="nav-item <?= $currentPage=='keluar'&&$currentDir=='stok'?'active':'' ?>">
                <i class="bi bi-box-arrow-up"></i><span>Barang Keluar</span>
            </a>
            <?php endif; ?>

            <?php if (in_array($user['role'], ['admin', 'kasir'])): ?>
            <a href="<?= BASE_URL ?>/modules/penjualan/riwayat.php" class="nav-item <?= $currentPage=='riwayat'?'active':'' ?>">
                <i class="bi bi-receipt"></i><span>Riwayat Penjualan</span>
            </a>
            <?php endif; ?>

            <?php if (in_array($user['role'], ['admin'])): ?>
            <div class="nav-section-title">Relasi</div>
            <a href="<?= BASE_URL ?>/modules/pelanggan/index.php" class="nav-item <?= $currentDir=='pelanggan'&&$currentPage=='index'?'active':'' ?>">
                <i class="bi bi-people"></i><span>Pelanggan</span>
            </a>
            <a href="<?= BASE_URL ?>/modules/pelanggan/loyalitas.php" class="nav-item <?= $currentPage=='loyalitas'?'active':'' ?>">
                <i class="bi bi-heart"></i><span>Program Loyalitas</span>
            </a>
            <a href="<?= BASE_URL ?>/modules/supplier/index.php" class="nav-item <?= $currentDir=='supplier'?'active':'' ?>">
                <i class="bi bi-building"></i><span>Supplier</span>
            </a>

            <div class="nav-section-title">Pengadaan</div>
            <a href="<?= BASE_URL ?>/modules/procurement/index.php" class="nav-item <?= $currentDir=='procurement'&&$currentPage=='index'?'active':'' ?>">
                <i class="bi bi-clipboard-check"></i><span>Purchase Order</span>
            </a>
            <a href="<?= BASE_URL ?>/modules/marketplace/index.php" class="nav-item <?= $currentDir=='marketplace'?'active':'' ?>">
                <i class="bi bi-shop-window"></i><span>Marketplace</span>
            </a>
            <a href="<?= BASE_URL ?>/modules/laporan/index.php" class="nav-item <?= $currentDir=='laporan'?'active':'' ?>">
                <i class="bi bi-graph-up"></i><span>Laporan</span>
            </a>
            <?php endif; ?>

            <?php if ($user['role'] === 'gudang'): ?>
            <div class="nav-section-title">Pengadaan</div>
            <a href="<?= BASE_URL ?>/modules/procurement/index.php" class="nav-item <?= $currentDir=='procurement'?'active':'' ?>">
                <i class="bi bi-truck"></i><span>Terima Barang</span>
            </a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <div class="sidebar-footer-info">
                <small>Ketoeroenan Doeloe v2.0</small>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <main class="main-content" id="mainContent">
        <div class="content-wrapper">
