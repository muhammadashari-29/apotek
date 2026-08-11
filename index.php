<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/koneksi.php';
cekLogin();

$totalObat     = $pdo->query("SELECT COUNT(*) FROM obat")->fetchColumn();
$totalKategori = $pdo->query("SELECT COUNT(*) FROM kategori")->fetchColumn();
$totalUser     = $pdo->query("SELECT COUNT(*) FROM user")->fetchColumn();
$obatNonaktif  = $pdo->query("SELECT COUNT(*) FROM obat WHERE status = 'nonaktif'")->fetchColumn();

$pageTitle = 'Dashboard - Sistem Apotek';
require_once __DIR__ . '/includes/header.php';
?>

<h3 class="mb-1">Dashboard</h3>
<p class="text-muted mb-4">Ringkasan data apotek hari ini.</p>

<?php if (isset($_GET['error']) && $_GET['error'] === 'akses_ditolak'): ?>
    <div class="alert alert-warning">Kamu tidak punya akses ke halaman tersebut.</div>
<?php endif; ?>

<div class="row g-3">
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <i class="bi bi-capsule text-primary fs-2"></i>
            <h3 class="mt-2 mb-0"><?= $totalObat ?></h3>
            <div class="text-muted small">Total Obat</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <i class="bi bi-tags text-success fs-2"></i>
            <h3 class="mt-2 mb-0"><?= $totalKategori ?></h3>
            <div class="text-muted small">Kategori</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <i class="bi bi-exclamation-triangle text-warning fs-2"></i>
            <h3 class="mt-2 mb-0"><?= $obatNonaktif ?></h3>
            <div class="text-muted small">Obat Nonaktif</div>
        </div>
    </div>
    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <i class="bi bi-people text-info fs-2"></i>
            <h3 class="mt-2 mb-0"><?= $totalUser ?></h3>
            <div class="text-muted small">Total User</div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="mt-4">
    <div class="card p-4">
        <h5><i class="bi bi-info-circle"></i> Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h5>
        <p class="text-muted mb-0">
            Gunakan menu di atas untuk mengelola data obat, kategori<?= ($_SESSION['role'] ?? '') === 'admin' ? ', dan user.' : '.' ?>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
