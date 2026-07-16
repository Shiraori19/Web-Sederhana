<?php
/**
 * Landing Page — Ketoeroenan Doeloe v2
 */

// Try connecting to show live stats
$stats = ['produk' => 0, 'pelanggan' => 0, 'transaksi' => 0];
$products = [];
try {
    $conn = new mysqli('localhost', 'root', '', 'sistem_atk2');
    if (!$conn->connect_error) {
        $conn->set_charset("utf8mb4");
        $r = $conn->query("SELECT COUNT(*) as c FROM produk WHERE is_active=1");
        if ($r) $stats['produk'] = $r->fetch_assoc()['c'];
        $r = $conn->query("SELECT COUNT(*) as c FROM pelanggan");
        if ($r) $stats['pelanggan'] = $r->fetch_assoc()['c'];
        $r = $conn->query("SELECT COUNT(*) as c FROM penjualan WHERE status='selesai'");
        if ($r) $stats['transaksi'] = $r->fetch_assoc()['c'];
        $r = $conn->query("SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori k ON p.kategori_id=k.id WHERE p.is_active=1 ORDER BY p.id DESC LIMIT 8");
        if ($r) while ($row = $r->fetch_assoc()) $products[] = $row;
        $conn->close();
    }
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ketoeroenan Doeloe — Sistem Informasi Toko Alat Tulis Kantor. Solusi terintegrasi untuk manajemen inventaris, penjualan multi-channel, dan e-procurement.">
    <title>Ketoeroenan Doeloe — Sistem Toko Alat Tulis Kantor Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="assets/css/landing.css" rel="stylesheet">
</head>
<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="brand-icon"><i class="bi bi-shop"></i></div>
                <span>Ketoeroenan <span class="text-gradient">Doeloe</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item"><a class="nav-link active" href="#hero">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#stats">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#workflow">Alur Kerja</a></li>
                </ul>
                <a href="modules/auth/login.php" class="btn btn-glow">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero-section" id="hero">
        <div class="hero-bg">
            <div class="hero-shape shape-1"></div>
            <div class="hero-shape shape-2"></div>
            <div class="hero-shape shape-3"></div>
            <div class="hero-grid"></div>
        </div>
        <div class="container hero-content">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1000">
                    <div class="hero-badge">
                        <i class="bi bi-stars me-1"></i> Sistem Informasi Terintegrasi v2.0
                    </div>
                    <h1 class="hero-title">
                        Kelola Toko ATK<br>
                        <span class="text-gradient">Lebih Cerdas</span> &<br>
                        <span class="text-gradient-2">Efisien</span>
                    </h1>
                    <p class="hero-desc">
                        Solusi lengkap untuk manajemen inventaris, penjualan multi-channel, 
                        e-procurement, dan program loyalitas pelanggan — semuanya dalam satu platform terintegrasi.
                    </p>
                    <div class="hero-actions">
                        <a href="modules/auth/login.php" class="btn btn-hero-primary">
                            <i class="bi bi-rocket-takeoff me-2"></i>Mulai Sekarang
                        </a>
                        <a href="#features" class="btn btn-hero-outline">
                            <i class="bi bi-play-circle me-2"></i>Pelajari Fitur
                        </a>
                    </div>
                    <div class="hero-trust">
                        <div class="trust-item">
                            <i class="bi bi-shield-check"></i>
                            <span>Aman & Terenkripsi</span>
                        </div>
                        <div class="trust-item">
                            <i class="bi bi-phone"></i>
                            <span>Mobile Friendly</span>
                        </div>
                        <div class="trust-item">
                            <i class="bi bi-lightning"></i>
                            <span>Real-time Sync</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="hero-visual">
                        <div class="floating-card card-1">
                            <i class="bi bi-graph-up-arrow"></i>
                            <div>
                                <small>Penjualan Hari Ini</small>
                                <strong>Rp 2.450.000</strong>
                            </div>
                        </div>
                        <div class="floating-card card-2">
                            <i class="bi bi-box-seam"></i>
                            <div>
                                <small>Stok Terupdate</small>
                                <strong>1,247 Item</strong>
                            </div>
                        </div>
                        <div class="floating-card card-3">
                            <i class="bi bi-people"></i>
                            <div>
                                <small>Pelanggan Aktif</small>
                                <strong>389 Orang</strong>
                            </div>
                        </div>
                        <div class="dashboard-preview">
                            <div class="preview-header">
                                <div class="preview-dots">
                                    <span></span><span></span><span></span>
                                </div>
                                <span class="preview-title">Dashboard</span>
                            </div>
                            <div class="preview-body">
                                <div class="mini-chart">
                                    <div class="bar" style="height:40%"></div>
                                    <div class="bar" style="height:65%"></div>
                                    <div class="bar" style="height:45%"></div>
                                    <div class="bar" style="height:80%"></div>
                                    <div class="bar" style="height:55%"></div>
                                    <div class="bar" style="height:90%"></div>
                                    <div class="bar active" style="height:70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-scroll-indicator" id="scrollIndicator">
            <div class="mouse">
                <div class="wheel"></div>
            </div>
            <span>Scroll ke bawah</span>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><i class="bi bi-gear me-1"></i>Fitur Unggulan</span>
                <h2 class="section-title">Semua yang Anda Butuhkan<br><span class="text-gradient">Dalam Satu Sistem</span></h2>
                <p class="section-desc">Dirancang khusus untuk toko ATK dengan fitur lengkap dan terintegrasi</p>
            </div>
            <div class="row g-4 mt-2">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon" style="--clr: #6366f1"><i class="bi bi-box-seam-fill"></i></div>
                        <h3>Manajemen Inventaris</h3>
                        <p>Pantau stok real-time dengan alert otomatis saat stok mendekati batas minimum. Catat barang masuk & keluar dengan mudah.</p>
                        <div class="feature-tags">
                            <span>Real-time</span><span>Auto-alert</span><span>Tracking</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon" style="--clr: #8b5cf6"><i class="bi bi-cart-check-fill"></i></div>
                        <h3>Point of Sale (POS)</h3>
                        <p>Kasir modern dengan interface intuitif. Dukung pembayaran Cash, QRIS, E-Wallet. Cetak invoice otomatis.</p>
                        <div class="feature-tags">
                            <span>Multi-Payment</span><span>Invoice</span><span>Quick</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon" style="--clr: #06b6d4"><i class="bi bi-shop-window"></i></div>
                        <h3>Multi-Channel Sales</h3>
                        <p>Integrasikan penjualan dari Toko Fisik, Shopee, Tokopedia, dan Website. Stok tersinkronisasi otomatis.</p>
                        <div class="feature-tags">
                            <span>Shopee</span><span>Tokopedia</span><span>Sync</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon" style="--clr: #f59e0b"><i class="bi bi-truck"></i></div>
                        <h3>E-Procurement</h3>
                        <p>Buat Purchase Order otomatis atau manual. Kirim langsung ke supplier. Lacak status PO real-time.</p>
                        <div class="feature-tags">
                            <span>Auto-PO</span><span>Supplier</span><span>Tracking</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon" style="--clr: #10b981"><i class="bi bi-heart-fill"></i></div>
                        <h3>Program Loyalitas</h3>
                        <p>Sistem poin otomatis untuk pembayaran digital. Level Bronze → Platinum. Tingkatkan retensi pelanggan.</p>
                        <div class="feature-tags">
                            <span>Poin</span><span>Level</span><span>Rewards</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon" style="--clr: #ef4444"><i class="bi bi-graph-up"></i></div>
                        <h3>Dashboard & Analytics</h3>
                        <p>Dashboard terpadu dengan grafik interaktif. Analisis tren penjualan, produk terlaris, dan revenue per channel.</p>
                        <div class="feature-tags">
                            <span>Charts</span><span>KPI</span><span>Insights</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRODUCT SHOWCASE ===== -->
    <section class="products-section" id="products">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><i class="bi bi-box me-1"></i>Katalog Produk</span>
                <h2 class="section-title">Produk <span class="text-gradient">Terkini</span></h2>
                <p class="section-desc">Diambil langsung dari database sistem</p>
            </div>
            <div class="row g-4 mt-2">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $i => $p): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 4) * 100 ?>">
                        <div class="product-card">
                            <div class="product-badge"><?= htmlspecialchars($p['nama_kategori'] ?? 'Umum') ?></div>
                            <div class="product-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h4><?= htmlspecialchars($p['nama']) ?></h4>
                            <div class="product-code"><?= htmlspecialchars($p['kode']) ?></div>
                            <div class="product-price">Rp <?= number_format($p['harga_jual'], 0, ',', '.') ?></div>
                            <div class="product-stock <?= $p['stok'] <= $p['stok_minimum'] ? 'low' : '' ?>">
                                <i class="bi bi-box"></i> Stok: <?= $p['stok'] ?> <?= $p['satuan'] ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center" data-aos="fade-up">
                        <div class="empty-state">
                            <i class="bi bi-database-x"></i>
                            <h4>Database belum terinstall</h4>
                            <p>Jalankan installer terlebih dahulu untuk melihat produk</p>
                            <a href="install.php" class="btn btn-glow mt-3">
                                <i class="bi bi-download me-2"></i>Install Sekarang
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ===== STATISTICS ===== -->
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="stats-grid-landing">
                <div class="stat-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-icon"><i class="bi bi-box-seam-fill"></i></div>
                    <div class="stat-number" data-count="<?= $stats['produk'] ?: 500 ?>">0</div>
                    <div class="stat-label">Produk Aktif</div>
                </div>
                <div class="stat-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-number" data-count="<?= $stats['pelanggan'] ?: 150 ?>">0</div>
                    <div class="stat-label">Pelanggan Terdaftar</div>
                </div>
                <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-icon"><i class="bi bi-receipt"></i></div>
                    <div class="stat-number" data-count="<?= $stats['transaksi'] ?: 1200 ?>">0</div>
                    <div class="stat-label">Total Transaksi</div>
                </div>
                <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
                    <div class="stat-icon"><i class="bi bi-shop"></i></div>
                    <div class="stat-number" data-count="4">0</div>
                    <div class="stat-label">Channel Penjualan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== WORKFLOW ===== -->
    <section class="workflow-section" id="workflow">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><i class="bi bi-diagram-3 me-1"></i>Alur Kerja</span>
                <h2 class="section-title">Proses Bisnis <span class="text-gradient">Terintegrasi</span></h2>
                <p class="section-desc">5 alur bisnis utama yang berjalan secara otomatis dan saling terhubung</p>
            </div>
            <div class="workflow-timeline">
                <div class="workflow-item" data-aos="fade-right" data-aos-delay="100">
                    <div class="workflow-number">01</div>
                    <div class="workflow-content">
                        <h3><i class="bi bi-box-seam me-2"></i>Manajemen Stok & Inventaris</h3>
                        <p>Petugas gudang update data barang masuk → Sistem sinkronisasi → Transaksi kasir gudang → Cek pembayaran digital → Update loyalitas otomatis</p>
                    </div>
                </div>
                <div class="workflow-item" data-aos="fade-left" data-aos-delay="200">
                    <div class="workflow-number">02</div>
                    <div class="workflow-content">
                        <h3><i class="bi bi-shop me-2"></i>Penjualan Toko Fisik</h3>
                        <p>Pelanggan beli di kasir → Validasi pembayaran (QRIS/E-Wallet) → Catat ke dashboard → Update profil pelanggan → Kurangi stok real-time</p>
                    </div>
                </div>
                <div class="workflow-item" data-aos="fade-right" data-aos-delay="300">
                    <div class="workflow-number">03</div>
                    <div class="workflow-content">
                        <h3><i class="bi bi-globe me-2"></i>Penjualan Marketplace</h3>
                        <p>Pesanan masuk (Shopee/Tokopedia/Website) → Validasi stok via sistem pusat → Sinkronisasi semua channel → Proses pengiriman</p>
                    </div>
                </div>
                <div class="workflow-item" data-aos="fade-left" data-aos-delay="400">
                    <div class="workflow-number">04</div>
                    <div class="workflow-content">
                        <h3><i class="bi bi-speedometer2 me-2"></i>Dashboard Terpadu</h3>
                        <p>Semua data transaksi terkumpul → Proses pesanan & pengiriman → Analisis tren penjualan → Insight produk terlaris & pola pelanggan</p>
                    </div>
                </div>
                <div class="workflow-item" data-aos="fade-right" data-aos-delay="500">
                    <div class="workflow-number">05</div>
                    <div class="workflow-content">
                        <h3><i class="bi bi-cart-plus me-2"></i>E-Procurement</h3>
                        <p>Sistem pantau stok minimum → Alert otomatis → PO otomatis/manual → Kirim ke supplier → Barang diterima → Update stok</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card" data-aos="zoom-in">
                <h2>Siap Mengelola Toko ATK<br>dengan <span class="text-gradient">Lebih Efisien</span>?</h2>
                <p>Mulai gunakan Sistem Ketoeroenan Doeloe sekarang. Gratis setup dan data demo sudah tersedia.</p>
                <div class="cta-actions">
                    <a href="modules/auth/login.php" class="btn btn-hero-primary btn-lg">
                        <i class="bi bi-rocket-takeoff me-2"></i>Login Dashboard
                    </a>
                    <a href="install.php" class="btn btn-hero-outline btn-lg">
                        <i class="bi bi-download me-2"></i>Install Sistem
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up">
                    <div class="footer-brand">
                        <div class="brand-icon"><i class="bi bi-shop"></i></div>
                        <span>Ketoeroenan <span class="text-gradient">Doeloe</span></span>
                    </div>
                    <p class="footer-desc">Sistem Informasi Toko Alat Tulis Kantor terintegrasi untuk mengelola inventaris, penjualan, dan procurement secara efisien.</p>
                </div>
                <div class="col-lg-2 col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <h5>Menu</h5>
                    <ul class="footer-links">
                        <li><a href="#hero">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#products">Produk</a></li>
                        <li><a href="#workflow">Alur Kerja</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <h5>Modul Sistem</h5>
                    <ul class="footer-links">
                        <li><a href="modules/auth/login.php">Dashboard</a></li>
                        <li><a href="modules/auth/login.php">POS / Kasir</a></li>
                        <li><a href="modules/auth/login.php">Inventaris</a></li>
                        <li><a href="modules/auth/login.php">Laporan</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <h5>Kontak</h5>
                    <ul class="footer-links">
                        <li><i class="bi bi-envelope me-2"></i>info@atkstore.com</li>
                        <li><i class="bi bi-telephone me-2"></i>+62 838 2301 7021</li>
                        <li><i class="bi bi-geo-alt me-2"></i>Jawa Barat, Indonesia</li>
                    </ul>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Ketoeroenan Doeloe v2.0 — Sistem Informasi Toko Alat Tulis Kantor</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/landing.js"></script>
</body>
</html>
