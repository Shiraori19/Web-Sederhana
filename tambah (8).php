<?php
$pageTitle = 'Kategori Produk';
require_once __DIR__ . '/../../includes/auth_check.php';
requireRole(['admin','gudang']);

// Handle CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $nama = sanitize($conn, $_POST['nama_kategori']);
        $desc = sanitize($conn, $_POST['deskripsi']);
        $icon = sanitize($conn, $_POST['icon'] ?: 'bi-tag');
        $conn->query("INSERT INTO kategori (nama_kategori,deskripsi,icon) VALUES ('$nama','$desc','$icon')");
        setFlash('success', 'Kategori berhasil ditambahkan!');
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $nama = sanitize($conn, $_POST['nama_kategori']);
        $desc = sanitize($conn, $_POST['deskripsi']);
        $icon = sanitize($conn, $_POST['icon'] ?: 'bi-tag');
        $conn->query("UPDATE kategori SET nama_kategori='$nama', deskripsi='$desc', icon='$icon' WHERE id=$id");
        setFlash('success', 'Kategori berhasil diupdate!');
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM kategori WHERE id=$id");
        setFlash('success', 'Kategori berhasil dihapus!');
    }
    header('Location: index.php'); exit;
}

$categories = [];
$r = $conn->query("SELECT k.*, (SELECT COUNT(*) FROM produk WHERE kategori_id=k.id AND is_active=1) as product_count FROM kategori k ORDER BY k.nama_kategori");
if ($r) while($row = $r->fetch_assoc()) $categories[] = $row;

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<div class="page-header">
    <div>
        <h1><i class="bi bi-tags me-2"></i>Kategori</h1>
        <p>Kelola kategori produk</p>
    </div>
    <button class="btn btn-primary-glass" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg me-2"></i>Tambah</button>
</div>

<div class="row g-3">
    <?php foreach($categories as $c): ?>
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card-glass">
            <div class="card-body text-center">
                <div style="width:56px;height:56px;background:rgba(99,102,241,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:24px;color:var(--primary-light)">
                    <i class="bi <?= $c['icon'] ?>"></i>
                </div>
                <h5 style="font-size:16px;font-weight:600;color:var(--text-bright);margin-bottom:4px"><?= htmlspecialchars($c['nama_kategori']) ?></h5>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px"><?= htmlspecialchars($c['deskripsi'] ?: '-') ?></p>
                <span class="badge-status badge-info"><?= $c['product_count'] ?> Produk</span>
                <div class="d-flex justify-content-center gap-1 mt-3">
                    <button class="btn-sm-icon" onclick="editKat(<?= htmlspecialchars(json_encode($c)) ?>)" title="Edit"><i class="bi bi-pencil"></i></button>
                    <form method="POST" style="display:inline" onsubmit="return confirm('Hapus kategori ini?')">
                        <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <button type="submit" class="btn-sm-icon danger" title="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if(empty($categories)): ?>
    <div class="col-12"><div class="empty-state-dash"><i class="bi bi-tag"></i><p>Belum ada kategori</p></div></div>
    <?php endif; ?>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal"><div class="modal-dialog"><div class="modal-content modal-content-glass">
    <div class="modal-header"><h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST"><input type="hidden" name="action" value="add">
    <div class="modal-body">
        <div class="mb-3"><label class="form-label-glass">Nama Kategori *</label><input type="text" name="nama_kategori" class="form-control form-control-glass" required></div>
        <div class="mb-3"><label class="form-label-glass">Deskripsi</label><input type="text" name="deskripsi" class="form-control form-control-glass"></div>
        <div class="mb-3"><label class="form-label-glass">Icon (Bootstrap Icons class)</label><input type="text" name="icon" class="form-control form-control-glass" value="bi-tag" placeholder="bi-tag"></div>
    </div>
    <div class="modal-footer"><button type="button" class="btn btn-outline-glass" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary-glass">Simpan</button></div>
    </form>
</div></div></div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal"><div class="modal-dialog"><div class="modal-content modal-content-glass">
    <div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Kategori</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form method="POST"><input type="hidden" name="action" value="edit"><input type="hidden" name="id" id="editId">
    <div class="modal-body">
        <div class="mb-3"><label class="form-label-glass">Nama Kategori *</label><input type="text" name="nama_kategori" id="editNama" class="form-control form-control-glass" required></div>
        <div class="mb-3"><label class="form-label-glass">Deskripsi</label><input type="text" name="deskripsi" id="editDesc" class="form-control form-control-glass"></div>
        <div class="mb-3"><label class="form-label-glass">Icon</label><input type="text" name="icon" id="editIcon" class="form-control form-control-glass"></div>
    </div>
    <div class="modal-footer"><button type="button" class="btn btn-outline-glass" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary-glass">Update</button></div>
    </form>
</div></div></div>

<script>
function editKat(data) {
    document.getElementById('editId').value = data.id;
    document.getElementById('editNama').value = data.nama_kategori;
    document.getElementById('editDesc').value = data.deskripsi || '';
    document.getElementById('editIcon').value = data.icon || 'bi-tag';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
