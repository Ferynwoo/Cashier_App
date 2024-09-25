<?php
include '../config/db.php'; // Sesuaikan dengan file koneksi

// Ambil data dari POST request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_penjualan'], $data['total'], $data['bayar'], $data['kembalian'])) {
    $id_penjualan = $data['id_penjualan'];
    $total = $data['total'];
    $bayar = $data['bayar'];
    $kembalian = $data['kembalian'];
    $status_transaksi = $data['status_transaksi'];

    // Simpan ke dalam tabel transaksi_selesai
    $query = "INSERT INTO transaksi_selesai (id_penjualan, total, bayar, kembalian, status_transaksi) 
              VALUES ('$id_penjualan', '$total', '$bayar', '$kembalian', '$status_transaksi')";

    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}
?>