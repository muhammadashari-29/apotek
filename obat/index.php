<?php
require_once __DIR__. '/../includes/auth.php';
require_once __DIR__. '/../config/koneksi.php';
cekLogin();

$sql = "SELECT obat.*, kategori.nama AS nama_kategori
		FROM obat
		JOIN kategori ON obat.kategori_id = kategori.id
		ORDER BY obat.id DESC";
$obat = $pdo->query($sql)->fetchAll();

$pageTitle ='Data Obat - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
	<h3 class="mb-0"><i class="bi bi-capsule"></i> Data Obat</h3>
	<a href="tambah.php" class="btn btn-primary">
		<i class="bi bi-plus-lg"></i> Tambah Obat
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
					<th>No</th>
					<th>Kode</th>
					<th>Nama Obat</th>
					<th>Kategori</th>
					<th>Status</th>
					<th class="text-end">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($obat)): ?>
					<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data obat.</td></tr>
				<?php else: foreach ($obat as $i => $o): ?>
					<tr>
						<td><?= $i + 1?></td>
						<td><span class="font-monospace"><?= htmlspecialchars($o['kode']) ?></span></td>
						<td><?= htmlspecialchars($o['nama_obat']) ?></td>
						<td><span class="badge bg-secondary"><?= htmlspecialchars($o['nama_kategori']) ?></span></td>
						<td>
							<span class="badge <?= $o['status'] === 'aktif' ? 'badge-status-aktif' : 'badge-status-nonaktif' ?>">
								<?= ucfirst($o['status']) ?>
							</span>
						</td>
						<td class="text-end">
							<a href="edit.php?id=<?=$o['id'] ?>" class="btn btn-sm btn-outline-warning">
								<i class="bi bi-pencil"></i> Edit
							</a>
							<a href="hapus.php?id=<?= $o['id'] ?>" class="btn btn-sm btn-outline-danger"
								onclick="return confirm('Yakin ingin menghapus obat ini?');">
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