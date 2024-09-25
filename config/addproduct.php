<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_baru";

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menghasilkan id_produk secara acak
    $id_produk = mt_rand(1000000, 9999999); // ID random 7 digit

    // Ambil data dari form
    $nama = $_POST['product_name'];
    $stok = $_POST['stok'];
    $jumlah_satuan = $_POST['jumlah_produk'];
    $satuan = $_POST['satuan_produk'];

    // Hapus titik pemisah ribuan dan ganti koma dengan titik untuk angka desimal
    $harga = str_replace('.', '', $_POST['harga']);
    $harga = str_replace(',', '.', $harga);

    // Query untuk memasukkan data ke tabel produk
    $query = "INSERT INTO produk (id_produk, nama_produk, harga, stok, jumlah_satuan, satuan) VALUES ('$id_produk', '$nama', '$harga', '$stok', '$jumlah_satuan', '$satuan')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "Produk berhasil ditambahkan!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    $conn->close();

    // Redirect kembali ke halaman produk
    header("Location: ../pages/product.php");
    exit();

    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $row = mysqli_fetch_assoc($query);
}
?>
