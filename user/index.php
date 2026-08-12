<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();
cekAdmin();

$users = $pdo->query("SELECT id, username, role FROM user ORDER BY id DESC")->fetchAll();

$pageTitle = 'Data User - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
	<h3 class="mb-0"><i class="bi bi-people"></i> Data User</h3>
	<a href="tambah.php" class="btn btn-primary">
		<i class="bi bi-plus-lg"></i> Tambah User
	</a>
</div>

<?php if (isset($_GET['msg'])): ?>
	<div class="alert alert-success alert-dismissible fade show">
		<?= htmlspecialchars($_GET['msg']) ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
	<div class="alert alert-danger alert-dismissible fade show">
		<?= htmlspecialchars($_GET['error']) ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
<?php endif; ?>

<div class="card p-3">
	<div class="table-responsive">
		<table class="table table-hover align-middle mb-0">
			<thead class="table-light">
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>Role</th>
					<th class="text-end">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($users)): ?>
					<tr><td colspan="4" class="text-center text-muted py-4">Belum ada data user.</td></tr>
				<?php else: foreach ($users as $i => $u): ?>
					<tr>
						<td><?= $i + 1 ?></td>
						<td><?= htmlspecialchars($u['username']) ?></td>
						<td>
							<span class="badge <?= $u['role'] === 'admin' ? 'bg-primary' : 'bg-secondary' ?> text-uppercase">
								<?= htmlspecialchars($u['role']) ?>
							</span>
						</td>
						<td class="text-end">
							<a href="edit.php?id=<?= $u['id']?>" class="btn btn-sm btn-outline-warning">
								<i class="bi bi-pencil"></i> Edit
							</a>
							<?php if ($u['id'] != $_SESSION['user_id']): ?>
							<a href="hapus.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger"
								onclick="return confirm('Yakin ingin menghapus user ini?');">
									<i class="bi bi-trash"></i> Hapus
							</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
	</div>
	
	<?php require_once __DIR__ . '/../includes/footer.php'; ?>