<?php
session_start();
require '../config/db.php'; // Koneksi ke database

// Cek apakah id_produk ada di URL
if (isset($_GET['id'])) {
    $id_penjualan = $_GET['id'];

    // Query untuk menghapus produk berdasarkan id_produk
    $query = "DELETE FROM penjualan WHERE id_penjualan = '$id_penjualan'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman produk setelah penghapusan berhasil
        header("Location: sales.php?message=Penjualan berhasil dihapus");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika id_produk tidak ada di URL, tampilkan pesan error
    echo "ID produk tidak ditemukan!";
}

// Tutup koneksi
$conn->close();
?>
