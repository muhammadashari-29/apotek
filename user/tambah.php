<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();
cekAdmin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'operator';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } elseif (strlen($password) < 8) {
        $error = 'Password minimal 8 karakter.';
    } else {
        $cek = $pdo->prepare('SELECT id FROM user WHERE username = ?');
        $cek->execute([$username]);
        if ($cek->fetch()) {
            $error = 'Username sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO user (username, password, role) VALUES (?, ?, ?)');
            $stmt->execute([$username, $hash, $role]);
            header('Location: index.php?msg=User berhasil ditambahkan');
            exit;
        }
    }
}

$pageTitle = 'Tambah User - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-3">
    <a href="index.php" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card p-4" style="max-width: 500px;">
    <h5 class="mb-3"><i class="bi bi-plus-lg"></i> Tambah User</h5>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            <div class="form-text">Minimal 6 karakter.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="operator">Operator</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
