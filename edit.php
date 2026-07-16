<?php
/**
 * Dashboard Terpadu — Ketoeroenan Doeloe v2
 */
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../../includes/auth_check.php';
requireLogin();

// KPI Data
$totalProduk = $conn->query("SELECT COUNT(*) c FROM produk WHERE is_active=1")->fetch_assoc()['c'];
$stokRendah = $conn->query("SELECT COUNT(*) c FROM produk WHERE stok <= stok_minimum AND is_active=1")->fetch_assoc()['c'];
$totalPelanggan = $conn->query("SELECT COUNT(*) c FROM pelanggan")->fetch_assoc()['c'];

$today = date('Y-m-d');
$txHariIni = $conn->query("SELECT COUNT(*) c, COALESCE(SUM(grand_total),0) s FROM penjualan WHERE DATE(tanggal)='$today' AND status='selesai'")->fetch_assoc();
$txBulanIni = $conn->query("SELECT COUNT(*) c, COALESCE(SUM(grand_total),0) s FROM penjualan WHERE MONTH(tanggal)=MONTH(NOW()) AND YEAR(tanggal)=YEAR(NOW()) AND status='selesai'")->fetch_assoc();
$poMenunggu = $conn->query("SELECT COUNT(*) c FROM purchase_order WHERE status IN ('draft','dikirim')")->fetch_assoc()['c'];

// Sales last 7 days
$salesData = [];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $r = $conn->query("SELECT COALESCE(SUM(grand_total),0) s FROM penjualan WHERE DATE(tanggal)='$d' AND status='selesai'");
    $salesData[] = ['date' => date('d M', strtotime($d)), 'total' => $r ? (float)$r->fetch_assoc()['s'] : 0];
}

// Top products
$topProducts = [];
$r = $conn->query("SELECT p.nama, SUM(dp.jumlah) qty, SUM(dp.subtotal) rev FROM detail_penjualan dp JOIN produk p ON dp.produk_id=p.id JOIN penjualan pj ON dp.penjualan_id=pj.id WHERE pj.status='selesai' GROUP BY dp.produk_id ORDER BY qty DESC LIMIT 5");
if ($r) while($row = $r->fetch_assoc()) $topProducts[] = $row;

// Channel breakdown
$channels = [];
$r = $conn->query("SELECT channel, COUNT(*) c, SUM(grand_total) s FROM penjualan WHERE status='selesai' GROUP BY channel");
if ($r) while($row = $r->fetch_assoc()) $channels[$row['channel']] = $row;

// Recent transactions
$recentTx = [];
$r = $conn->query("SELECT pj.*, pl.nama as pelanggan_nama FROM penjualan pj LEFT JOIN pelanggan pl ON pj.pelanggan_id=pl.id WHERE pj.status='selesai' ORDER BY pj.tanggal DESC LIMIT 8");
if ($r) while($row = $r->fetch_assoc()) $recentTx[] = $row;

// Low stock items
$lowStockItems = [];
$r = $conn->query("SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori k ON p.kategori_id=k.id WHERE p.stok<=p.stok_minimum AND p.is_active=1 ORDER BY (p.stok/p.stok_minimum) ASC LIMIT 5");
if ($r) while($row = $r->fetch_assoc()) $lowStockItems[] = $row;

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1>Dashboard <span style="font-weight:300; font-size:18px; color:var(--text-muted);">• <?= date('l, d F Y') ?></span></h1>
        <p>Selamat datang kembali, <?= htmlspecialchars($user['nama']) ?>!</p>
    </div>
    <?php if (in_array($user['role'], ['admin','kasir'])): ?>
    <a href="../penjualan/kasir.php" class="btn btn-primary-glass">
        <i class="bi bi-cart3 me-2"></i>Buka Kasir
    </a>
    <?php endif; ?>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: var(--primary)">
            <div class="kpi-icon" style="background:rgba(99,102,241,0.12); color:var(--primary-light)"><i class="bi bi-box-seam-fill"></i></div>
            <div class="kpi-value"><?= $totalProduk ?></div>
            <div class="kpi-label">Total Produk Aktif</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: var(--success)">
            <div class="kpi-icon" style="background:rgba(16,185,129,0.12); color:var(--success)"><i class="bi bi-receipt"></i></div>
            <div class="kpi-value"><?= $txHariIni['c'] ?></div>
            <div class="kpi-label">Transaksi Hari Ini</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: var(--accent)">
            <div class="kpi-icon" style="background:rgba(6,182,212,0.12); color:var(--accent)"><i class="bi bi-cash-stack"></i></div>
            <div class="kpi-value"><?= formatRupiah($txBulanIni['s']) ?></div>
            <div class="kpi-label">Revenue Bulan Ini</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: <?= $stokRendah > 0 ? 'var(--danger)' : 'var(--warning)' ?>">
            <div class="kpi-icon" style="background:<?= $stokRendah > 0 ? 'rgba(239,68,68,0.12)' : 'rgba(245,158,11,0.12)' ?>; color:<?= $stokRendah > 0 ? 'var(--danger)' : 'var(--warning)' ?>">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="kpi-value"><?= $stokRendah ?></div>
            <div class="kpi-label">Alert Stok Rendah</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: var(--info)">
            <div class="kpi-icon" style="background:rgba(59,130,246,0.12); color:var(--info)"><i class="bi bi-cash-coin"></i></div>
            <div class="kpi-value"><?= formatRupiah($txHariIni['s']) ?></div>
            <div class="kpi-label">Penjualan Hari Ini</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: var(--secondary)">
            <div class="kpi-icon" style="background:rgba(139,92,246,0.12); color:var(--secondary)"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-value"><?= $totalPelanggan ?></div>
            <div class="kpi-label">Total Pelanggan</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: var(--warning)">
            <div class="kpi-icon" style="background:rgba(245,158,11,0.12); color:var(--warning)"><i class="bi bi-clipboard-check"></i></div>
            <div class="kpi-value"><?= $poMenunggu ?></div>
            <div class="kpi-label">PO Menunggu</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr: var(--accent-2)">
            <div class="kpi-icon" style="background:rgba(20,184,166,0.12); color:var(--accent-2)"><i class="bi bi-shop-window"></i></div>
            <div class="kpi-value"><?= count($channels) ?></div>
            <div class="kpi-label">Channel Aktif</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card-glass">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-graph-up me-2"></i>Tren Penjualan 7 Hari</span>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-glass">
            <div class="card-header"><i class="bi bi-pie-chart me-2"></i>Penjualan per Channel</div>
            <div class="card-body">
                <canvas id="channelChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card-glass">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</span>
                <a href="../penjualan/riwayat.php" class="btn btn-outline-glass btn-sm" style="font-size:12px;">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-glass">
                        <thead><tr><th>Invoice</th><th>Pelanggan</th><th>Channel</th><th>Total</th><th>Waktu</th></tr></thead>
                        <tbody>
                        <?php foreach($recentTx as $tx): ?>
                        <tr>
                            <td><strong><?= $tx['no_invoice'] ?></strong></td>
                            <td><?= htmlspecialchars($tx['pelanggan_nama'] ?? 'Walk-in') ?></td>
                            <td><span class="badge-status badge-info"><?= ucfirst($tx['channel']) ?></span></td>
                            <td><?= formatRupiah($tx['grand_total']) ?></td>
                            <td style="color:var(--text-muted);font-size:12px;"><?= date('d/m H:i', strtotime($tx['tanggal'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($recentTx)): ?>
                        <tr><td colspan="5" class="text-center" style="padding:32px;color:var(--text-muted);">Belum ada transaksi</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-glass mb-3">
            <div class="card-header"><i class="bi bi-trophy me-2"></i>Produk Terlaris</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-glass">
                        <thead><tr><th>Produk</th><th>Terjual</th><th>Revenue</th></tr></thead>
                        <tbody>
                        <?php foreach($topProducts as $tp): ?>
                        <tr>
                            <td><?= htmlspecialchars($tp['nama']) ?></td>
                            <td><strong><?= $tp['qty'] ?></strong></td>
                            <td><?= formatRupiah($tp['rev']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($topProducts)): ?>
                        <tr><td colspan="3" class="text-center" style="padding:24px;color:var(--text-muted);">Belum ada data</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php if (!empty($lowStockItems)): ?>
        <div class="card-glass" style="border-color:rgba(239,68,68,0.25);">
            <div class="card-header" style="color:var(--danger)"><i class="bi bi-exclamation-triangle me-2"></i>Stok Rendah</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-glass">
                        <thead><tr><th>Produk</th><th>Stok</th><th>Min</th></tr></thead>
                        <tbody>
                        <?php foreach($lowStockItems as $ls): ?>
                        <tr>
                            <td><?= htmlspecialchars($ls['nama']) ?></td>
                            <td><span class="badge-status badge-danger"><?= $ls['stok'] ?></span></td>
                            <td><?= $ls['stok_minimum'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    // Sales chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($salesData, 'date')) ?>,
                datasets: [{
                    label: 'Penjualan',
                    data: <?= json_encode(array_column($salesData, 'total')) ?>,
                    borderColor: '#818cf8',
                    backgroundColor: 'rgba(129,140,248,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#818cf8',
                    pointBorderWidth: 0,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: 'rgba(99,102,241,0.06)' }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                    y: {
                        grid: { color: 'rgba(99,102,241,0.06)' },
                        ticks: { color: '#94a3b8', font: { size: 11 }, callback: v => 'Rp ' + (v/1000) + 'K' }
                    }
                }
            }
        });
    }

    // Channel chart
    const channelCtx = document.getElementById('channelChart');
    if (channelCtx) {
        const chData = <?= json_encode($channels) ?>;
        const labels = Object.keys(chData).map(k => k.charAt(0).toUpperCase() + k.slice(1));
        const values = Object.values(chData).map(v => v.c);
        if (labels.length > 0) {
            new Chart(channelCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: ['#6366f1','#f59e0b','#10b981','#06b6d4','#8b5cf6'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#94a3b8', padding: 12, font: { size: 11 } } }
                    }
                }
            });
        }
    }
});
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
