<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

function cekLogin()
{
	if (!isset($_SESSION['user.id'])) {
		header('Location: /apotek/auth/login.php');
		exit;
	}
}

function cekAdmin()
{
	if (($_SESSION['role'] ?? '') !== 'admin') {
		header('Location: /apotek/index.php?error=akses_ditolak');
		exit;
	}
}