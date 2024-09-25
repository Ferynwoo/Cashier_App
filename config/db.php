<?php
$host = 'localhost';
$db = 'kasir_baru'; // ganti dengan nama database Anda
$user = 'root'; // ganti dengan username database Anda
$pass = ''; // ganti dengan password database Anda

// Buat koneksi menggunakan MySQLi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (mysqli_connect_errno()) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
