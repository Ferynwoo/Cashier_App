<?php
include '../config/db.php'; // Sesuaikan dengan koneksi database Anda

if (isset($_GET['id_penjualan'])) {
    $id_penjualan = $_GET['id_penjualan'];

    // Ambil data penjualan
    $query_penjualan = "SELECT * FROM penjualan WHERE id_penjualan = '$id_penjualan'";
    $result_penjualan = mysqli_query($koneksi, $query_penjualan);
    $penjualan = mysqli_fetch_assoc($result_penjualan);

    // Ambil detail produk yang dibeli
    $query_detail = "SELECT p.nama_produk, dp.jumlah_produk, p.harga, dp.subtotal 
                   FROM detailpenjualan dp 
                   JOIN produk p ON dp.id_produk = p.id_produk 
                   WHERE dp.id_penjualan = '$id_penjualan'";
    $result_detail = mysqli_query($koneksi, $query_detail);
?>

    <p>ID Penjualan: <?php echo $penjualan['id_penjualan']; ?></p>
    <p>Tanggal: <?php echo $penjualan['tanggal_penjualan']; ?></p>
    <p>ID Pelanggan: <?php echo $penjualan['id_pelanggan']; ?></p>

    <table>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
        <?php
        if (mysqli_num_rows($result_detail) > 0) {
            while ($row = mysqli_fetch_assoc($result_detail)) {
                echo "<tr>";
                echo "<td>" . $row['nama_produk'] . "</td>";
                echo "<td>" . $row['jumlah_produk'] . "</td>";
                echo "<td>" . number_format($row['harga'], 2) . "</td>";
                echo "<td>" . number_format($row['subtotal'], 2) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data ditemukan untuk penjualan ini.</td></tr>";
        }
        ?>
    <tr>
        <td><strong>Total</strong></td>
        <td></td>
        <td></td>
        <td><?php echo number_format($penjualan['total_harga'], 2); ?></td>
    </tr>
    </table>

    <input type="hidden"  id="total" value="<?php echo $penjualan['total_harga']; ?>" data-id-penjualan="<?php echo $penjualan['id_penjualan']; ?>">

<?php
}
?>


<script>
    fetch("getdetail.php?id_penjualan=" + id_penjualan)
  .then(response => response.text())
  .then(html => {
    console.log("HTML from server:", html); // Log server response
    document.getElementById("saleDetails").innerHTML = html;
  })
  .catch(error => console.error("Error fetching details:", error));

</script>

<style>
    table {
    width: 100%; /* Full width */
    border-collapse: collapse; /* Remove gaps between cells */
    margin: 20px 0; /* Margin above and below the table */
}

th, td {
    padding: 12px; /* Padding inside cells */
    text-align: left; /* Align text to the left */  
}

th {
    background-color: #f2f2f2; /* Light gray background for headers */
    color: #333; /* Dark text color for headers */
}

tr:hover {
    background-color: #f5f5f5; /* Light gray background on row hover */
}

td[colspan] {
    font-weight: bold; /* Bold text for colspan cells */
}

</style>
