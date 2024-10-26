<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika tidak login, redirect ke halaman login
    exit();
}

session_start();
session_destroy(); // Hapus session
header("Location: login.php"); // Redirect ke halaman login
exit();
