<?php
$pageTitle = 'Pelanggan';
require_once __DIR__ . '/../../includes/auth_check.php';
requireRole(['admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $n = sanitize($conn,$_POST['nama']); $t = sanitize($conn,$_POST['telepon']);
        $e = sanitize($conn,$_POST['email']); $a = sanitize($conn,$_POST['alamat']);
        $conn->query("INSERT INTO pelanggan (nama,telepon,email,alamat) VALUES ('$n','$t','$e','$a')");
        setFlash('success','Pelanggan berhasil ditambahkan!');
    } elseif ($action === 'edit') {
        $id=(int)$_POST['id']; $n=sanitize($conn,$_POST['nama']); $t=sanitize($conn,$_POST['telepon']);
        $e=sanitize($conn,$_POST['email']); $a=sanitize($conn,$_POST['alamat']);
        $conn->query("UPDATE pelanggan SET nama='$n',telepon='$t',email='$e',alamat='$a' WHERE id=$id");
        setFlash('success','Pelanggan berhasil diupdate!');
    } elseif ($action === 'delete') {
        $conn->query("DELETE FROM pelanggan WHERE id=".(int)$_POST['id']);
        setFlash('success','Pelanggan berhasil dihapus!');
    }
    header('Location: index.php'); exit;
}

$customers = [];
$r = $conn->query("SELECT * FROM pelanggan ORDER BY nama");
if ($r) while($row = $r->fetch_assoc()) $customers[] = $row;

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/sidebar.php';

$levelColors = ['Bronze'=>'badge-secondary','Silver'=>'badge-info','Gold'=>'badge-warning','Platinum'=>'badge-primary'];
?>

<div class="page-header">
    <div><h1><i class="bi bi-people me-2"></i>Pelanggan</h1><p>Kelola data pelanggan</p></div>
    <button class="btn btn-primary-glass" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg me-2"></i>Tambah</button>
</div>

<div class="card-glass">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table-glass">
                <thead><tr><th>Nama</th><th>Telepon</th><th>Email</th><th>Level</th><th>Poin</th><th>Total Belanja</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach($customers as $c): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($c['nama']) ?></strong></td>
                    <td><?= $c['telepon'] ?></td>
                    <td style="color:var(--text-muted)"><?= $c['email'] ?></td>
                    <td><span class="badge-status <?= $levelColors[$c['level']] ?? 'badge-secondary' ?>"><?= $c['level'] ?></span></td>
                    <td><strong style="color:var(--warning)"><?= $c['poin_loyalitas'] ?></strong></td>
                    <td><?= formatRupiah($c['total_belanja']) ?></td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn-sm-icon" onclick='editPel(<?= json_encode($c) ?>)' title="Edit"><i class="bi bi-pencil"></i></button>
                            <form method="POST" style="display:inline" onsubmit="return confirm('Hapus?')"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $c['id'] ?>"><button class="btn-sm-icon danger"><i class="bi bi-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($customers)): ?><tr><td colspan="7" class="empty-state-dash">Belum ada pelanggan</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal"><div class="modal-dialog"><div class="modal-content modal-content-glass">
<div class="modal-header"><h5 class="modal-title">Tambah Pelanggan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST"><input type="hidden" name="action" value="add">
<div class="modal-body">
    <div class="mb-3"><label class="form-label-glass">Nama *</label><input type="text" name="nama" class="form-control form-control-glass" required></div>
    <div class="mb-3"><label class="form-label-glass">Telepon</label><input type="text" name="telepon" class="form-control form-control-glass"></div>
    <div class="mb-3"><label class="form-label-glass">Email</label><input type="email" name="email" class="form-control form-control-glass"></div>
    <div class="mb-3"><label class="form-label-glass">Alamat</label><textarea name="alamat" class="form-control form-control-glass" rows="2"></textarea></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-outline-glass" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary-glass">Simpan</button></div>
</form></div></div></div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal"><div class="modal-dialog"><div class="modal-content modal-content-glass">
<div class="modal-header"><h5 class="modal-title">Edit Pelanggan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST"><input type="hidden" name="action" value="edit"><input type="hidden" name="id" id="eId">
<div class="modal-body">
    <div class="mb-3"><label class="form-label-glass">Nama *</label><input type="text" name="nama" id="eNama" class="form-control form-control-glass" required></div>
    <div class="mb-3"><label class="form-label-glass">Telepon</label><input type="text" name="telepon" id="eTelepon" class="form-control form-control-glass"></div>
    <div class="mb-3"><label class="form-label-glass">Email</label><input type="email" name="email" id="eEmail" class="form-control form-control-glass"></div>
    <div class="mb-3"><label class="form-label-glass">Alamat</label><textarea name="alamat" id="eAlamat" class="form-control form-control-glass" rows="2"></textarea></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-outline-glass" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary-glass">Update</button></div>
</form></div></div></div>

<script>
function editPel(d) {
    document.getElementById('eId').value=d.id; document.getElementById('eNama').value=d.nama;
    document.getElementById('eTelepon').value=d.telepon||''; document.getElementById('eEmail').value=d.email||'';
    document.getElementById('eAlamat').value=d.alamat||'';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
