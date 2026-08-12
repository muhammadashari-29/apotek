<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/koneksi.php';
cekLogin();

$id = $_GET['id'] ?? null;
if (!$id) {
	header('Location: index.php');
	exit;
}   
$stmt = $pdo->prepare('SELECT * FROM obat WHERE id = ?');
$stmt->execute([id]);
$obat = $stmt->fetch();

if (!$obat) {
	header('Location: index.php?msg=Obat tidak ditemukan');
	exit;
} 

$kategoriList = $pdo->query("SELECT * FROM kategori ORDER BY nama")->fetchAll();
$error = ''; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$kode				= trim($_POST['kode'] ?? '');
	$nama_obat			= trim($_POST['nama_obat'] ?? '');
	$kategori_id		= $_POST['kategori_id'] ?? '';
	$status				= $_POST['status'] ?? 'aktif';
	
	if ($kode === '' || $nama_oabat === '' || $kategori_id === '' ) {
		$error = 'Semua field wajib diisi.';
	} else {
		$cek = $pdo->prepare('SELECT id FROM obat WHERE kode = ? AND id != ?');
	}
}

?>