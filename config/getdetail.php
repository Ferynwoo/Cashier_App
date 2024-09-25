<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_baru";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID penjualan
$id_penjualan = $_GET['id'];

// Query untuk mendapatkan detail penjualan
$sql = "SELECT penjualan.id_penjualan, penjualan.tanggal_penjualan, penjualan.id_pelanggan, produk.nama_produk as produk_beli, produk.harga as harga_produk, penjualan.total_harga
        FROM penjualan 
        JOIN detailpenjualan ON penjualan.id_penjualan = detailpenjualan.id_penjualan
        JOIN produk ON detailpenjualan.id_produk = produk.id_produk
        WHERE penjualan.id_penjualan = $id_penjualan";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Kirim hasil dalam format JSON
echo json_encode($data);
?>

<script>
function showDetail(id_penjualan) {
  // Panggil file getdetail.php via AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "getdetail.php?id_penjualan=" + id_penjualan, true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById("detailContent").innerHTML = xhr.responseText;
      // Tampilkan modal setelah data diterima
      var modal = new bootstrap.Modal(document.getElementById('detailModal'));
      modal.show();
    }
  };
  xhr.send();
}

function printDetail() {
  var detailContent = document.getElementById("detailContent").innerHTML;
  var newWindow = window.open('', '', 'height=400,width=600');
  newWindow.document.write('<html><head><title>Print</title></head><body>');
  newWindow.document.write(detailContent);
  newWindow.document.write('</body></html>');
  newWindow.print();
  newWindow.close();
}
</script>
