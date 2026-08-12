<?php
require_once __DIR__ .'/../includes/auth.php';
require_once __DIR__ .'/../config/koneksi.php';
cekLogin();

$id = $_GET['id'] ?? null;

if ($id) {
	$stmt =$pdo->prepare('DELETE FROM obat WHERE id = ?');
	$stmt->execute([$id]);
}

header('Location: index.php?msg=Obat berhasil dihapus');
exit;
?>