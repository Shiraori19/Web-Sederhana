<?php
$pageTitle = 'Marketplace';
require_once __DIR__ . '/../../includes/auth_check.php';
requireRole(['admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = sanitize($conn, $_POST['status_pengiriman']);
    $resi = sanitize($conn, $_POST['no_resi']);
    $kurir = sanitize($conn, $_POST['kurir']);
    $conn->query("UPDATE marketplace_orders SET status_pengiriman='$status', no_resi='$resi', kurir='$kurir' WHERE id=$id");
    setFlash('success', 'Status pesanan diupdate!');
    header('Location: index.php'); exit;
}

// Get marketplace orders joined with penjualan
$orders = [];
$r = $conn->query("SELECT mo.*, pj.no_invoice, pj.grand_total, pj.tanggal FROM marketplace_orders mo LEFT JOIN penjualan pj ON mo.penjualan_id=pj.id ORDER BY mo.created_at DESC");
if ($r) while($row = $r->fetch_assoc()) $orders[] = $row;

// Get channel sales without marketplace_orders entry
$channelSales = [];
$r = $conn->query("SELECT pj.* FROM penjualan pj WHERE pj.channel IN ('shopee','tokopedia','website') AND pj.id NOT IN (SELECT COALESCE(penjualan_id,0) FROM marketplace_orders) AND pj.status='selesai' ORDER BY pj.tanggal DESC LIMIT 20");
if ($r) while($row = $r->fetch_assoc()) $channelSales[] = $row;

$platformCounts = ['shopee'=>0,'tokopedia'=>0,'website'=>0];
$r = $conn->query("SELECT channel, COUNT(*) c FROM penjualan WHERE channel IN ('shopee','tokopedia','website') AND status='selesai' GROUP BY channel");
if ($r) while($row = $r->fetch_assoc()) $platformCounts[$row['channel']] = $row['c'];

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/sidebar.php';

$statusColors = ['pending'=>'badge-secondary','diproses'=>'badge-warning','dikirim'=>'badge-info','selesai'=>'badge-success','batal'=>'badge-danger'];
$platformIcons = ['shopee'=>'🟠','tokopedia'=>'🟢','website'=>'🌐','lainnya'=>'📦'];
?>

<div class="page-header">
    <div><h1><i class="bi bi-shop-window me-2"></i>Marketplace</h1><p>Kelola pesanan dari berbagai platform</p></div>
</div>

<!-- Platform Stats -->
<div class="row g-3 mb-4">
    <?php foreach($platformCounts as $plt => $cnt): ?>
    <div class="col-md-4">
        <div class="kpi-card">
            <div class="d-flex align-items-center gap-3">
                <div style="font-size:32px"><?= $platformIcons[$plt] ?></div>
                <div><div class="kpi-value"><?= $cnt ?></div><div class="kpi-label"><?= ucfirst($plt) ?> Orders</div></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Marketplace Orders -->
<?php if(!empty($orders)): ?>
<div class="card-glass mb-4">
    <div class="card-header"><i class="bi bi-truck me-2"></i>Pesanan Marketplace (Tracking)</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table-glass">
                <thead><tr><th>Platform</th><th>Order ID</th><th>Pembeli</th><th>Invoice</th><th>Total</th><th>Status</th><th>Resi</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach($orders as $o): ?>
                <tr>
                    <td><?= $platformIcons[$o['platform']] ?? '' ?> <?= ucfirst($o['platform']) ?></td>
                    <td><code><?= $o['order_id_external'] ?: '-' ?></code></td>
                    <td><?= htmlspecialchars($o['nama_pembeli'] ?? '-') ?></td>
                    <td><?= $o['no_invoice'] ?? '-' ?></td>
                    <td><?= $o['grand_total'] ? formatRupiah($o['grand_total']) : '-' ?></td>
                    <td><span class="badge-status <?= $statusColors[$o['status_pengiriman']] ?>"><?= ucfirst($o['status_pengiriman']) ?></span></td>
                    <td><?= $o['no_resi'] ?: '-' ?></td>
                    <td><button class="btn-sm-icon" onclick='editOrder(<?= json_encode($o) ?>)'><i class="bi bi-pencil"></i></button></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Channel Sales -->
<div class="card-glass">
    <div class="card-header"><i class="bi bi-cart-check me-2"></i>Penjualan Online Terbaru</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table-glass">
                <thead><tr><th>Invoice</th><th>Channel</th><th>Total</th><th>Metode</th><th>Tanggal</th></tr></thead>
                <tbody>
                <?php foreach($channelSales as $cs): ?>
                <tr>
                    <td><strong><?= $cs['no_invoice'] ?></strong></td>
                    <td><?= $platformIcons[$cs['channel']] ?? '' ?> <?= ucfirst($cs['channel']) ?></td>
                    <td><?= formatRupiah($cs['grand_total']) ?></td>
                    <td><span class="badge-status badge-primary"><?= strtoupper($cs['metode_bayar']) ?></span></td>
                    <td><?= date('d/m/Y H:i', strtotime($cs['tanggal'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($channelSales) && empty($orders)): ?>
                <tr><td colspan="5" class="empty-state-dash">Belum ada pesanan marketplace</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal"><div class="modal-dialog"><div class="modal-content modal-content-glass">
<div class="modal-header"><h5 class="modal-title">Update Status Pesanan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST"><input type="hidden" name="update_status" value="1"><input type="hidden" name="id" id="moId">
<div class="modal-body">
    <div class="mb-3"><label class="form-label-glass">Status</label><select name="status_pengiriman" id="moStatus" class="form-select form-select-glass">
        <option value="pending">Pending</option><option value="diproses">Diproses</option><option value="dikirim">Dikirim</option><option value="selesai">Selesai</option><option value="batal">Batal</option>
    </select></div>
    <div class="mb-3"><label class="form-label-glass">No Resi</label><input type="text" name="no_resi" id="moResi" class="form-control form-control-glass"></div>
    <div class="mb-3"><label class="form-label-glass">Kurir</label><input type="text" name="kurir" id="moKurir" class="form-control form-control-glass"></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-outline-glass" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary-glass">Update</button></div>
</form></div></div></div>

<script>
function editOrder(d) {
    document.getElementById('moId').value=d.id;
    document.getElementById('moStatus').value=d.status_pengiriman;
    document.getElementById('moResi').value=d.no_resi||'';
    document.getElementById('moKurir').value=d.kurir||'';
    new bootstrap.Modal(document.getElementById('editOrderModal')).show();
}
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
