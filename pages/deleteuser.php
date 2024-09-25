<?php
session_start();
require '../config/db.php'; // Koneksi ke database

// Cek apakah id_produk ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Menggunakan variabel yang benar

    // Query untuk menghapus user berdasarkan id
    $query = "DELETE FROM users WHERE id = '$id'"; // Pastikan kolom yang digunakan di query adalah kolom yang benar

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman daftar user setelah penghapusan berhasil
        header("Location: user.php?message=User berhasil dihapus");
        exit();
    } else {
        // Tampilkan error jika query gagal
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika id_produk tidak ada di URL, tampilkan pesan error
    echo "User ID tidak ditemukan!";
}

// Tutup koneksi
$koneksi->close();
?>
