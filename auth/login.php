<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /apotek/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            header('Location: /apotek/index.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    }
}

$pageTitle = 'Login - Sistem Apotek';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/apotek/assets/style.css">
</head>
<body>
<div class="login-wrapper">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <div class="text-center mb-4">
                <i class="bi bi-capsule-fill text-primary" style="font-size: 2.5rem;"></i>
                <h4 class="mt-2 fw-bold">Sistem Apotek</h4>
                <p class="text-muted small">Silakan login untuk melanjutkan</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>

            <div class="text-center mt-3 small text-muted">
                Akun contoh: <code>admin / admin123</code> atau <code>operator1 / operator123</code>
            </div>
        </div>
    </div>
</div>
</body>
</html>
