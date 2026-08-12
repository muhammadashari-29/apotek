<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nama	= trim($_POST['nama'] ?? '');
	$status	= $_POST['status'] ?? 'aktif';
	
	if ($nama === '') {
		$error = 'Nama kategori wajib diisi.';
	} else {
		$stmt = $pdo->prepare('INSERT INTO kategori (nama, status) VALUES (?, ?)');
		$stmt ->execute([$nama, $status]);
		header('Location: index.php?msg=Kategori berhasil ditambahkan');
		exit;
	}
}

$pageTitle = 'Tambah Kategori - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-3">
	<a href="index.php" class="btn btn-sm btn-outline-secondary">
		<i class="bi bi-arrow-left"></i> Kembali
	</a>
</div>

<div class="card p-4" style="max-width: 500px;">
	<h5 class="mb-3"><i class="bi bi-plus-lg></i> Tambah Kategori</h5>
	
	<?php if ($error): ?>
		<div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
	<?php endif; ?>
	
	<form method="POST">
		<div class="mb-3">
			<label class="form-label">Nama Kategori</label>
			<input type="text" name="nama" class="form-control"
				value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
		</div>
		<div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
