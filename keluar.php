<?php
$pageTitle = 'Laporan & Analytics';
require_once __DIR__ . '/../../includes/auth_check.php';
requireRole(['admin']);

$dateFrom = sanitize($conn, $_GET['from'] ?? date('Y-m-d', strtotime('-30 days')));
$dateTo = sanitize($conn, $_GET['to'] ?? date('Y-m-d'));

// Revenue stats
$revenue = $conn->query("SELECT COALESCE(SUM(grand_total),0) s, COUNT(*) c FROM penjualan WHERE status='selesai' AND DATE(tanggal) BETWEEN '$dateFrom' AND '$dateTo'")->fetch_assoc();

// Daily trend
$dailyData = [];
$r = $conn->query("SELECT DATE(tanggal) d, SUM(grand_total) s, COUNT(*) c FROM penjualan WHERE status='selesai' AND DATE(tanggal) BETWEEN '$dateFrom' AND '$dateTo' GROUP BY DATE(tanggal) ORDER BY d");
if ($r) while($row = $r->fetch_assoc()) $dailyData[] = $row;

// Channel breakdown
$channelData = [];
$r = $conn->query("SELECT channel, SUM(grand_total) s, COUNT(*) c FROM penjualan WHERE status='selesai' AND DATE(tanggal) BETWEEN '$dateFrom' AND '$dateTo' GROUP BY channel");
if ($r) while($row = $r->fetch_assoc()) $channelData[$row['channel']] = $row;

// Payment method breakdown
$paymentData = [];
$r = $conn->query("SELECT metode_bayar, SUM(grand_total) s, COUNT(*) c FROM penjualan WHERE status='selesai' AND DATE(tanggal) BETWEEN '$dateFrom' AND '$dateTo' GROUP BY metode_bayar");
if ($r) while($row = $r->fetch_assoc()) $paymentData[$row['metode_bayar']] = $row;

// Top products
$topProds = [];
$r = $conn->query("SELECT p.nama, SUM(dp.jumlah) qty, SUM(dp.subtotal) rev FROM detail_penjualan dp JOIN produk p ON dp.produk_id=p.id JOIN penjualan pj ON dp.penjualan_id=pj.id WHERE pj.status='selesai' AND DATE(pj.tanggal) BETWEEN '$dateFrom' AND '$dateTo' GROUP BY dp.produk_id ORDER BY qty DESC LIMIT 10");
if ($r) while($row = $r->fetch_assoc()) $topProds[] = $row;

// Average transaction
$avgTx = $revenue['c'] > 0 ? $revenue['s'] / $revenue['c'] : 0;

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<div class="page-header">
    <div><h1><i class="bi bi-graph-up me-2"></i>Laporan & Analytics</h1><p>Analisis tren penjualan dan performa bisnis</p></div>
</div>

<!-- Date Filter -->
<div class="card-glass mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3"><label class="form-label-glass">Dari Tanggal</label><input type="date" name="from" class="form-control form-control-glass" value="<?= $dateFrom ?>"></div>
            <div class="col-md-3"><label class="form-label-glass">Sampai Tanggal</label><input type="date" name="to" class="form-control form-control-glass" value="<?= $dateTo ?>"></div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary-glass w-100"><i class="bi bi-funnel me-1"></i>Filter</button></div>
            <div class="col-md-2"><button type="button" onclick="window.print()" class="btn w-100" style="background:rgba(16,185,129,0.15);color:#10b981;border:1px solid rgba(16,185,129,0.3)"><i class="bi bi-printer me-1"></i>Cetak PDF</button></div>
        </form>
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr:var(--success)">
            <div class="kpi-icon" style="background:rgba(16,185,129,0.12);color:var(--success)"><i class="bi bi-cash-stack"></i></div>
            <div class="kpi-value"><?= formatRupiah($revenue['s']) ?></div>
            <div class="kpi-label">Total Revenue</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr:var(--primary)">
            <div class="kpi-icon" style="background:rgba(99,102,241,0.12);color:var(--primary-light)"><i class="bi bi-receipt"></i></div>
            <div class="kpi-value"><?= $revenue['c'] ?></div>
            <div class="kpi-label">Total Transaksi</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr:var(--accent)">
            <div class="kpi-icon" style="background:rgba(6,182,212,0.12);color:var(--accent)"><i class="bi bi-calculator"></i></div>
            <div class="kpi-value"><?= formatRupiah($avgTx) ?></div>
            <div class="kpi-label">Rata-rata / Transaksi</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card" style="--kpi-clr:var(--warning)">
            <div class="kpi-icon" style="background:rgba(245,158,11,0.12);color:var(--warning)"><i class="bi bi-shop"></i></div>
            <div class="kpi-value"><?= count($channelData) ?></div>
            <div class="kpi-label">Channel Aktif</div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card-glass">
            <div class="card-header"><i class="bi bi-bar-chart me-2"></i>Tren Penjualan Harian</div>
            <div class="card-body"><canvas id="dailyChart" height="100"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-glass mb-3">
            <div class="card-header"><i class="bi bi-pie-chart me-2"></i>Per Channel</div>
            <div class="card-body"><canvas id="channelChart" height="180"></canvas></div>
        </div>
        <div class="card-glass">
            <div class="card-header"><i class="bi bi-credit-card me-2"></i>Metode Bayar</div>
            <div class="card-body"><canvas id="paymentChart" height="180"></canvas></div>
        </div>
    </div>
</div>

<!-- Top Products -->
<div class="card-glass">
    <div class="card-header"><i class="bi bi-trophy me-2"></i>Top 10 Produk Terlaris (Periode ini)</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table-glass">
                <thead><tr><th>#</th><th>Produk</th><th>Terjual</th><th>Revenue</th><th>Kontribusi</th></tr></thead>
                <tbody>
                <?php foreach($topProds as $i=>$tp): 
                    $pct = $revenue['s'] > 0 ? ($tp['rev'] / $revenue['s']) * 100 : 0;
                ?>
                <tr>
                    <td><strong><?= $i+1 ?></strong></td>
                    <td><strong><?= htmlspecialchars($tp['nama']) ?></strong></td>
                    <td><span class="badge-status badge-info"><?= $tp['qty'] ?></span></td>
                    <td><?= formatRupiah($tp['rev']) ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:80px;height:6px;background:var(--dark-3);border-radius:3px;overflow:hidden">
                                <div style="width:<?= min($pct*2,100) ?>%;height:100%;background:var(--primary);border-radius:3px"></div>
                            </div>
                            <small style="color:var(--text-muted)"><?= number_format($pct,1) ?>%</small>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($topProds)): ?><tr><td colspan="5" class="empty-state-dash">Tidak ada data</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    body { background: white !important; color: black !important; }
    .sidebar, nav, form, .page-header p, .btn { display: none !important; }
    .main-content, .main-wrapper, body { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
    .card-glass { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; box-shadow: none !important; border: 1px solid #ddd !important; break-inside: avoid; margin-bottom:15px; }
    .page-header h1, .kpi-value, .kpi-label, th, td, .card-header, strong { color: black !important; }
    canvas { max-height: 250px !important; }
    @page { margin: 1cm; size: landscape; }
}
</style>
<script>
window.addEventListener('load', function() {
    // Daily chart
    const dailyCtx = document.getElementById('dailyChart');
    if (dailyCtx) {
        new Chart(dailyCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_map(fn($d) => date('d M', strtotime($d['d'])), $dailyData)) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?= json_encode(array_column($dailyData, 's')) ?>,
                    backgroundColor: 'rgba(99,102,241,0.6)',
                    borderColor: '#6366f1',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: 'rgba(99,102,241,0.06)' }, ticks: { color: '#94a3b8', font: { size: 10 } } },
                    y: { grid: { color: 'rgba(99,102,241,0.06)' }, ticks: { color: '#94a3b8', font: { size: 10 }, callback: v => 'Rp '+(v/1000)+'K' } }
                }
            }
        });
    }

    // Channel chart
    const channelLabels = <?= json_encode(array_map('ucfirst', array_keys($channelData))) ?>;
    const channelValues = <?= json_encode(array_map(fn($v)=>$v['c'], array_values($channelData))) ?>;
    if (channelLabels.length > 0) {
        new Chart(document.getElementById('channelChart'), {
            type: 'doughnut',
            data: {
                labels: channelLabels,
                datasets: [{ data: channelValues, backgroundColor:['#6366f1','#f59e0b','#10b981','#06b6d4'], borderWidth:0 }]
            },
            options: { responsive:true, cutout:'60%', plugins:{legend:{position:'bottom',labels:{color:'#94a3b8',font:{size:11}}}} }
        });
    }

    // Payment chart
    const payLabels = <?= json_encode(array_map('strtoupper', array_keys($paymentData))) ?>;
    const payValues = <?= json_encode(array_map(fn($v)=>$v['c'], array_values($paymentData))) ?>;
    if (payLabels.length > 0) {
        new Chart(document.getElementById('paymentChart'), {
            type: 'doughnut',
            data: {
                labels: payLabels,
                datasets: [{ data: payValues, backgroundColor:['#10b981','#8b5cf6','#f59e0b','#06b6d4'], borderWidth:0 }]
            },
            options: { responsive:true, cutout:'60%', plugins:{legend:{position:'bottom',labels:{color:'#94a3b8',font:{size:11}}}} }
        });
    }
});
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
