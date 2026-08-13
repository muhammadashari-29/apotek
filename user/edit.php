<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();
cekAdmin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: index.php?msg=User tidak ditemukan');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'operator';

    if ($username === '') {
        $error = 'Username wajib diisi.';
    } else {
        $cek = $pdo->prepare('SELECT id FROM user WHERE username = ? AND id != ?');
        $cek->execute([$username, $id]);
        if ($cek->fetch()) {
            $error = 'Username sudah digunakan oleh user lain.';
        } else {
            if ($password !== '') {
                if (strlen($password) < 6) {
                    $error = 'Password baru minimal 6 karakter.';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare('UPDATE user SET username = ?, password = ?, role = ? WHERE id = ?');
                    $stmt->execute([$username, $hash, $role, $id]);
                }
            } else {
                $stmt = $pdo->prepare('UPDATE user SET username = ?, role = ? WHERE id = ?');
                $stmt->execute([$username, $role, $id]);
            }

            if (!$error) {
                header('Location: index.php?msg=User berhasil diperbarui');
                exit;
            }
        }
    }
}

$pageTitle = 'Edit User - Sistem Apotek';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-3">
    <a href="index.php" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card p-4" style="max-width: 500px;">
    <h5 class="mb-3"><i class="bi bi-pencil"></i> Edit User</h5>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="<?= htmlspecialchars($_POST['username'] ?? $user['username']) ?>" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control">
            <div class="form-text">Kosongkan jika tidak ingin mengubah password.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="operator" <?= $user['role'] === 'operator' ? 'selected' : '' ?>>Operator</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">
            <i class="bi bi-save"></i> Perbarui
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
