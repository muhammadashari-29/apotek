<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();

$kategori = $pdo->query("SELECT * FROM kategori ORDER BY id DESC")->fetchAll();

$pageTitle = 'Data Kategori - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
	<h3 class="mb-0"><i class="bi bi-tags"></i> Data Kategori</h3>
	<a href="tambah.php" class="btn btn-primary">
		<i class="bi bi-plus-lg"></i> Tambah Kategori
	</a>
</div>

<?php if (isset($_GET['msg'])): ?>
	<div class="alert alert-success alert-dismissible fade show">
		<?= htmlspecialchars($_GET['msg']) ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
<?php endif; ?>

<div class="card p-3">
	<div class="table-responsive">
		<table class="table table-hover align-middle mb-0">
			<thead class="table-light">
				<tr>
					<th>#</th>
					<th>Nama Kategori</th>
					<th>Status</th>
					<th class="text-end">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($kategori)): ?>
					<tr><td colspan="4" class="text-center text-muted py-4">Belum ada data kategori.</td></tr>
				<?php else: foreach ($kategori as $i => $k): ?>
					<tr>
						<td><?= $i + 1 ?></td>
						<td><?= htmlspecialchars($k['nama']) ?></td>
						<td>
							<span class="badge <?= $k['status'] === 'aktif' ? 'badge-status-aktif' : 'badge-status-nonaktif' ?>">
								<?= ucfirst($k['status']) ?>
							</span>
						</td>
						<td class="text-end">
							<a href="edit.php?id=<?= $k['id'] ?>" class="btn btn-sm btn-outline-warning">
								<i class="bi bi-pencil"></i> Edit
							</a>
							<a href="hapus.php?id=<?= $k['id'] ?>" class="btn btn-sm btn-outline-danger"
							   onclick="return confirm('Yakin ingin menghapus kategori ini? Obat terkait juga akan terhapus.');">
								<i class="bi bi-trash"></i> Hapus
							</a>
						</td>
					</tr>
				<?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>