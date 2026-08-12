<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

function cekLogin()
{
	if (!isset($_SESSION['user_id'])) {
<<<<<<< HEAD
		header('Location:/auth/login.php');
=======
		header('Location: /auth/login.php');
>>>>>>> 16920a7 (Perbaikan kode yang bermasalah)
		exit;
	}
}

function cekAdmin()
{
	if (($_SESSION['role'] ?? '') !== 'admin') {
<<<<<<< HEAD
		header('Location:/index.php?error=akses_ditolak');
=======
		header('Location: /index.php?error=akses_ditolak');
>>>>>>> 16920a7 (Perbaikan kode yang bermasalah)
		exit;
	}
}