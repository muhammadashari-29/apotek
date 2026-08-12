<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $pageTitle ?? 'Sistem Apotek' ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/style.css">
</head>
<body class="bg-light">

<?php if (isset($_SESSION['user_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
	<div class="container">
		<a class="navbar-brand fw-bold" href="/index.php">
			<i class="bi bi-capsule-fill"></i> Apotek Sehat
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navMain">
			<ul class="navbar-nav me-auto">
				<li class="nav-item">
					<a class="nav-link" href="/index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/obat/index.php"><i class="bi bi-capsule"></i> Data Obat</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/kategori/index.php"><i class="bi bi-tags"></i> Kategori</a>
				</li>
				<?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/user/index.php"><i class="bi bi-people"></i> Data User</a>
                </li>
				<?php endif; ?>
			</ul>
			<span class="navbar-text text-white me-3">
				<i class="bi bi-person-circle"></i>
				<?= htmlspecialchars($_SESSION['username']) ?>
			</span>
			<a href="/auth/logout.php" class="btn btn-outline-danger btn-sm">
				<i class="bi bi-box-arrow-right"></i> Keluar
			</a>
		</div>
	</div>
</nav>
<?php endif; ?>

<main class="container py-4">
				