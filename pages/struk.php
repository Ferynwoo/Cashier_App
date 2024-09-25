    <?php
    include '../config/db.php'; // Ganti dengan file koneksi yang sesuai

    if (isset($_GET['id'])) {
        $id_penjualan = $_GET['id'];

        // Ambil data penjualan
        $query_penjualan = "SELECT p.*, ts.total, ts.bayar, ts.kembalian 
                            FROM penjualan p 
                            JOIN transaksi_selesai ts ON p.id_penjualan = ts.id_penjualan
                            WHERE p.id_penjualan = '$id_penjualan'";
        $result_penjualan = mysqli_query($koneksi, $query_penjualan);

        if ($penjualan = mysqli_fetch_assoc($result_penjualan)) {
            // Ambil detail produk yang dibeli
            $query_detail = "SELECT p.nama_produk, dp.jumlah_produk, p.harga, dp.subtotal 
                            FROM detailpenjualan dp 
                            JOIN produk p ON dp.id_produk = p.id_produk 
                            WHERE dp.id_penjualan = '$id_penjualan'";
            $result_detail = mysqli_query($koneksi, $query_detail);
    ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Struk Penjualan</title>
                <style>
                    body {
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        color: #333;
                        max-width: 380px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #f8f9fa;
                        border: 1px solid #e0e0e0;
                        border-radius: 10px;
                    }

                    h2 {
                        text-align: center;
                        color: #e91e63;
                        border-bottom: 2px solid #e91e63;
                        padding-bottom: 10px;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }

                    th,
                    td {
                        padding: 10px;
                        text-align: left;
                    }

                    th {
                        border-bottom: 2px solid #e91e63;
                    }

                    td {
                        border-bottom: 1px solid #e0e0e0;
                    }

                    p {
                        font-size: 12px;
                        /* Atur ke ukuran spesifik */
                    }

                    .total,
                    .bayar,
                    .kembalian {
                        text-align: right;
                    }

                    .summary p {
                        font-size: 13px;
                        margin: 5px 0;
                    }

                    .note {
                        text-align: center;
                        margin-top: 20px;
                        font-style: italic;
                        color: #555;
                    }

                    /* Print styles */
                    @media print {
                        body {
                            background-color: white;
                            font-size: 12px;
                            margin: 0;
                        }

                        .print-btn {
                            display: none;
                        }
                    }
                </style>
            </head>

            <body>
                <h2>Detail Penjualan</h2>
                <p>ID Penjualan: <strong><?php echo $penjualan['id_penjualan']; ?></strong></p>
                <p>Tanggal: <?php echo date('d M Y, H:i', strtotime($penjualan['tanggal_penjualan'])); ?></p>
                <p>ID Pelanggan: <?php echo $penjualan['id_pelanggan']; ?></p>

                <table>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result_detail)) { ?>
                        <tr>
                            <td><?php echo $row['nama_produk']; ?></td>
                            <td><?php echo $row['jumlah_produk']; ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 2); ?></td>
                            <td>Rp <?php echo number_format($row['subtotal'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <div class="summary">
                    <p class="total"><strong>Total: Rp <?php echo number_format($penjualan['total'], 2); ?></strong></p>
                    <p class="bayar">Bayar: Rp <?php echo number_format($penjualan['bayar'], 2); ?></p>
                    <p class="kembalian">Kembalian: Rp <?php echo number_format($penjualan['kembalian'], 2); ?></p>
                </div>

                <p class="note">Terima kasih telah berbelanja!</p>

                <button class="print-btn" onclick="window.print()">Print Struk</button>
            </body>

            </html>

    <?php
        } else {
            echo "Penjualan tidak ditemukan!";
        }
    } else {
        echo "ID Penjualan tidak ditemukan!";
    }
    ?>