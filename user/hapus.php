<?php 
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();
cekAdmin();

$id = $GET['id'] ?? null;

if ($id) {
	if ($id == $_SESSION['user_id']) {
		header('Location: index.php?error=Tidak bisa menghapus akun sendiri yang sedang login.');
		exit;
	}
	$stmt = $pdo->prepare('DELETE FROM user WHERE id = ?');
	$stmt->execute([$id]);
} 

header('Location: index.php?msg=User berhasil dihapus');
exit;
?>