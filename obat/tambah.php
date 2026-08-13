<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();

$kategoriList = $pdo->query("SELECT * FROM kategori WHERE status = 'aktif' ORDER BY nama")->fetchAll();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$kode				= trim($_POST['kode'] ?? '');
	$nama_obat			= trim($_POST['nama_obat'] ?? '');
	$kategori_id		= $_POST['kategori_id'] ?? '';
	$status				= $_POST['status'] ?? 'aktif';
	
	if ($kode === '' || $nama_obat === '' || $kategori_id === '') {
		$error = 'Semua field wajib diisi.';
	} else {
		$cek = $pdo->prepare('SELECT id FROM obat WHERE kode = ?');
		$cek->execute([$kode]);
		if ($cek->fetch()) {
			$error = 'Kode obat sudah digunakan, gunakan kode lain.';
		} else {
			$stmt = $pdo->prepare('INSERT INTO obat (kode, nama_obat, kategori_id, status) VALUES (?,?,?,?)');
			$stmt->execute([$kode, $nama_obat, $kategori_id, $status]);
			header('Location: index.php?msg=Obat berhasil ditambahkan');
			exit;
		}
	}
}

$pageTitle = 'Tambah Obat - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-3">
	<a href="index.php" class="btn btn-sm btn-outline-secondary">
		<i class="bi bi-arrow-left"></i> Kembali
	</a>
</div>

<div class="card p-4" style="max-width: 550px;">
	<h5 class="mb-3"><i class="bi bi-plus-lg"></i> Tambah Obat</h5>
	
	<?php if ($error): ?>
		<div class="alert alert-danger py-2"><?=htmlspecialchars($error) ?></div>
	<?php endif; ?>
	
	<?php if (empty($kategoriList)): ?>
		<div class="alert alert-warning py-2">
			Belum ada kategori aktif. Tambahkan kategori terlebih dahulu sebelum menambah obat.
		</div>
	
	<?php else: ?>
	<form method="POST">
		<div class="mb-3">
			<label class="form-label">Kode Obat</label>
			<input type="text" name="kode" class="form-control"
					value="<?= htmlspecialchars($_POST['kode'] ?? '') ?>" required autofocus>
		</div>
		<div class="mb-3">
			<label class="form-label">Nama Obat</label>
			<input type="text" name="nama_obat" class="form-control"
					value="<?= htmlspecialchars($_POST['nama_obat'] ?? '') ?>" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Kategori</label>
			<select name="kategori_id" class="form-select" required>
				<option value="">-- Pilih Kategori --</option>
				<?php foreach ($kategoriList as $k): ?>
					<option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama']) ?></option>
				<?php endforeach; ?>
			</select>
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
	<?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>