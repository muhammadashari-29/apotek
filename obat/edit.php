<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM obat WHERE id = ?');
$stmt->execute([$id]);
$obat = $stmt->fetch();

if (!$obat) {
    header('Location: index.php?msg=Obat tidak ditemukan');
    exit;
}

$kategoriList = $pdo->query("SELECT * FROM kategori ORDER BY nama")->fetchAll();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode        = trim($_POST['kode'] ?? '');
    $nama_obat   = trim($_POST['nama_obat'] ?? '');
    $kategori_id = $_POST['kategori_id'] ?? '';
    $status      = $_POST['status'] ?? 'aktif';
    
    if ($kode === '' || $nama_obat === '' || $kategori_id === '') {
        $error = 'Semua field wajib diisi.';
    } else {
        $cek = $pdo->prepare('SELECT id FROM obat WHERE kode = ? AND id != ?');
        $cek->execute([$kode, $id]);
        if ($cek->fetch()) {
            $error = 'Kode obat sudah digunakan oleh obat lain.';
        } else {
            $stmt = $pdo->prepare('UPDATE obat SET kode = ?, nama_obat = ?, kategori_id = ?, status = ? WHERE id = ?');
            $stmt->execute([$kode, $nama_obat, $kategori_id, $status, $id]);
            header('Location: index.php?msg=Obat berhasil diperbarui');
            exit;
        }
    }
}

$pageTitle = 'Edit Obat - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-3">
    <a href="index.php" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card p-4" style="max-width: 550px;">
   
    <h5 class="mb-3"><i class="bi bi-pencil"></i> Edit Obat</h5>
    
    <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Kode Obat</label>
            <input type="text" name="kode" class="form-control"
                   value="<?= htmlspecialchars($_POST['kode'] ?? $obat['kode']) ?>" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control"
                   value="<?= htmlspecialchars($_POST['nama_obat'] ?? $obat['nama_obat']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select" required>
                <?php 
                
                $selectedKategori = $_POST['kategori_id'] ?? $obat['kategori_id'];
                foreach ($kategoriList as $k): 
                ?>
                    <option value="<?= $k['id'] ?>" <?= (string)$k['id'] === (string)$selectedKategori ? 'selected' : '' ?>>
                        <?= htmlspecialchars($k['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <?php $selectedStatus = $_POST['status'] ?? $obat['status']; ?>
            <select name="status" class="form-select">
                <option value="aktif" <?= $selectedStatus === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $selectedStatus === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">
            <i class="bi bi-save"></i> Perbarui
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>