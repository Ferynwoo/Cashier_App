<?php
session_start();

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

// Cek apakah parameter id ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data produk berdasarkan id
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id'");

    // Cek apakah produk ditemukan
    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query); // Data produk ditemukan
    } else {
        echo "Produk tidak ditemukan!";
        exit(); // Hentikan eksekusi jika produk tidak ditemukan
    }
} else {
    echo "ID produk tidak ditemukan!";
    exit(); // Hentikan eksekusi jika ID tidak ada
}

// Proses edit produk jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id_produk'];  // Pastikan ID produk dikirim via form
    $nama = $_POST['product_name'];
    $stok = $_POST['stok'];
    $jumlah_satuan = $_POST['jumlah_produk'];
    $satuan = $_POST['satuan_produk'];

    // Hapus titik pemisah ribuan dan ganti koma dengan titik untuk angka desimal
    $harga = $_POST['harga'];


    // Query untuk memperbarui data produk
    $query = "UPDATE produk SET nama_produk = '$nama', stok = '$stok', jumlah_satuan = '$jumlah_satuan', satuan = '$satuan', harga = '$harga' WHERE id_produk = '$id'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "Produk berhasil diperbarui!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    $conn->close();

    // Redirect kembali ke halaman produk
    header("Location: ../pages/product.php");
    exit();
}
?>
