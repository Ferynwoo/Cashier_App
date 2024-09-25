<?php
session_start();
require '../config/db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_penjualan = $_POST['id_penjualan'];
    $member_type = $_POST['member_type'];
    $id_pelanggan = isset($_POST['nama_pelanggan']) ? $_POST['nama_pelanggan'] : null;
    $total_harga = $_POST['total_harga'];
    $produk_ids = $_POST['satuan_produk'];
    $jumlah_produk = $_POST['dibeli'];

    // Insert into penjualan table
    $query_penjualan = "INSERT INTO penjualan (id_penjualan, id_pelanggan, total_harga, tanggal_penjualan) VALUES ('$id_penjualan', '$id_pelanggan', $total_harga, NOW())";

    if (mysqli_query($koneksi, $query_penjualan)) {
        // untuk mendapatkan idpenjualan terbaru (mengambalikan)
        $last_insert_id = mysqli_insert_id($koneksi);

        // Prepare insert for detail_penjualan
        $detail_query = "INSERT INTO detailpenjualan (id_penjualan, id_produk, jumlah_produk , subtotal) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $detail_query);

        // memproses, transaksi
        // produk_ids, proses produk tiap transaksi
        // jumlah, menyimpan jumlah produk yang terjual
        foreach ($produk_ids as $index => $id_produk) { 
            $jumlah = $jumlah_produk[$index];

            // menyiapkan statement untuk memproses
            $sqlStock = "SELECT stok, harga FROM produk WHERE id_produk = ?";
            // Menyiapkan statement SQL dengan placeholde
            $product_stmt = mysqli_prepare($koneksi, $sqlStock);
            // Mengikat variabel $username, $email, dan $password ke query ke parameter
            mysqli_stmt_bind_param($product_stmt, "i", $id_produk);
            // Menjalankan query yang sudah disiapkan menggunakan parameter
            mysqli_stmt_execute($product_stmt);
            // mengikat hasil dari query
            mysqli_stmt_bind_result($product_stmt, $stok, $harga);
            // mengambil baris hasil query dari database
            mysqli_stmt_fetch($product_stmt);
            // tutup
            mysqli_stmt_close($product_stmt);

            if ($stok >= $jumlah) {
                // Calculate subtotal
                $subtotal = $harga * $jumlah;

                // Insert into detailpenjualan
                mysqli_stmt_bind_param($stmt, "siid", $id_penjualan, $id_produk, $jumlah, $subtotal);
                mysqli_stmt_execute($stmt);

                // Update stock in produk table
                $new_stock = $stok - $jumlah;
                $update_stock_query = "UPDATE produk SET stok = ? WHERE id_produk = ?";
                $update_stmt = mysqli_prepare($koneksi, $update_stock_query);
                mysqli_stmt_bind_param($update_stmt, "ii", $new_stock, $id_produk);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            } else {
                // If stock is insufficient, return error
                $_SESSION['error'] = "Stok untuk produk ID $id_produk tidak mencukupi!";
                header("Location: ../pages/sales.php");
                exit();
            }
        }

        mysqli_stmt_close($stmt);

        // If successful, redirect
        $_SESSION['message'] = 'Penjualan berhasil ditambahkan!';
        header("Location: ../pages/sales.php");
        exit();
    } else {
        // If failed, show error message
        $_SESSION['error'] = 'Gagal menambahkan penjualan: ' . mysqli_error($koneksi);
        header("Location: ../pages/sales.php");
        exit();
    }
}
