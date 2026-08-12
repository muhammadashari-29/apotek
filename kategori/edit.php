<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM kategori WHERE id = ?');
$stmt->execute([$id]);
$kategori = $stmt->fetch();

if (!$kategori) {
    header('Location: index.php?msg=Kategori tidak ditemukan');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $status = $_POST['status'] ?? 'aktif';

    if ($nama === '') {
        $error = 'Nama kategori wajib diisi.';
    } else {
        $stmt = $pdo->prepare('UPDATE kategori SET nama = ?, status = ? WHERE id = ?');
        $stmt->execute([$nama, $status, $id]);
        header('Location: index.php?msg=Kategori berhasil diperbarui');
        exit;
    }
}

$pageTitle = 'Edit Kategori - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-3">
    <a href="index.php" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card p-4" style="max-width: 500px;">
    <h5 class="mb-3"><i class="bi bi-pencil"></i> Edit Kategori</h5>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control"
                   value="<?= htmlspecialchars($_POST['nama'] ?? $kategori['nama']) ?>" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="aktif" <?= $kategori['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $kategori['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">
            <i class="bi bi-save"></i> Perbarui
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
