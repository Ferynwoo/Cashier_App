<?php
session_start();
require '../config/db.php'; // Koneksi ke database

$detail_penjualan = []; // Inisialisasi array kosong untuk menghindari error undefined variable
$total_harga = 0; // Inisialisasi total_harga

if (isset($_GET['id_penjualan'])) {
    $id_penjualan = $_GET['id_penjualan'];

    // Query untuk mengambil detail penjualan
    $query = "
        SELECT 
            penjualan.id_penjualan,
            penjualan.tanggal_penjualan,
            penjualan.id_pelanggan,
            pelanggan.nama_pelanggan,
            produk.nama_produk,
            detail_penjualan.jumlah_produk,
            produk.harga,
            (detail_penjualan.jumlah_produk * produk.harga) AS subtotal
        FROM detail_penjualan
        JOIN penjualan ON penjualan.id_penjualan = detail_penjualan.id_penjualan
        JOIN produk ON produk.id_produk = detail_penjualan.id_produk
        JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
        WHERE penjualan.id_penjualan = '$id_penjualan'
    ";

    $result = mysqli_query($koneksi, $query);
    if ($result) {
        $detail_penjualan = mysqli_fetch_all($result, MYSQLI_ASSOC); // Mengambil hasil query
    }

    // Query untuk mengambil total harga
    $query_total = "
        SELECT SUM(detail_penjualan.jumlah_produk * produk.harga) AS total_harga
        FROM detail_penjualan
        JOIN produk ON produk.id_produk = detail_penjualan.id_produk
        WHERE detail_penjualan.id_penjualan = '$id_penjualan'
    ";
    $result_total = mysqli_query($koneksi, $query_total);
    if ($result_total) {
        $row_total = mysqli_fetch_assoc($result_total);
        $total_harga = $row_total['total_harga'] ?? 0; // Menangani kasus null
    }

    // Cek apakah pelanggan mendapat diskon
    $query_member = "
        SELECT penjualan.id_pelanggan, pelanggan.nama_pelanggan
        FROM penjualan
        JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
        WHERE penjualan.id_penjualan = '$id_penjualan'
    ";
    $result_member = mysqli_query($koneksi, $query_member);
    $row_member = mysqli_fetch_assoc($result_member);
    $is_member = isset($row_member['id_pelanggan']) && $row_member['id_pelanggan'] !== '0000';

    // Hitung diskon jika pelanggan adalah member
    $diskon = $is_member ? $total_harga * 0.03 : 0;
    $total_setelah_diskon = $total_harga - $diskon;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2>Detail Penjualan</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Penjualan</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($detail_penjualan): ?>
            <?php foreach ($detail_penjualan as $detail): ?>
                <tr>
                    <td><?= $detail['id_penjualan'] ?></td>
                    <td><?= $detail['tanggal_penjualan'] ?></td>
                    <td><?= $detail['nama_pelanggan'] ?></td>
                    <td><?= $detail['nama_produk'] ?></td>
                    <td><?= $detail['jumlah_produk'] ?></td>
                    <td>Rp <?= number_format($detail['harga'], 2, ',', '.') ?></td>
                    <td>Rp <?= number_format($detail['subtotal'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada detail penjualan ditemukan.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <h5>Total Harga: Rp <?= number_format($total_harga, 2, ',', '.') ?></h5>
        <?php if ($is_member): ?>
            <h6>Potongan 3%: Rp <?= number_format($diskon, 2, ',', '.') ?></h6>
        <?php endif; ?>
        <h5>Total Setelah Diskon: Rp <?= number_format($total_setelah_diskon, 2, ',', '.') ?></h5>
    </div>

    <!-- Bagian untuk input pembayaran dan kembali -->
    <form action="proses_pembayaran.php" method="post">
        <input type="hidden" name="id_penjualan" value="<?= $id_penjualan ?>">
        <div class="mb-3">
            <label for="total_bayar" class="form-label">Total Bayar</label>
            <input type="number" class="form-control" name="total_bayar" id="total_bayar" required oninput="updateKembalian(<?= $total_setelah_diskon ?>)">
        </div>
        <div class="mb-3">
            <label for="kembalian" class="form-label">Kembalian</label>
            <input type="text" class="form-control" id="kembalian" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Bayar</button>
    </form>
</div>

<script>
    function updateKembalian(total_setelah_diskon) {
        const totalBayar = document.getElementById('total_bayar').value;
        const kembalian = totalBayar - total_setelah_diskon;
        document.getElementById('kembalian').value = kembalian > 0 ? kembalian.toFixed(2) : 0;
    }
</script>
</body>
</html>
