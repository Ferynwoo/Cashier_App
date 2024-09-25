<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_baru_baru";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah parameter id ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data pelanggan berdasarkan id
    $query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan = '$id'");

    // Cek apakah pelanggan ditemukan
    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query); // Data pelanggan ditemukan
    } else {
        echo "Pelanggan tidak ditemukan!";
        exit(); // Hentikan eksekusi jika pelanggan tidak ditemukan
    }
} else {
    echo "ID pelanggan tidak ditemukan!";
    exit(); // Hentikan eksekusi jika ID tidak ada
}

// Proses edit pelanggan jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_pelanggan = $_POST['id_pelanggan'];  
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    // Query untuk memperbarui data pelanggan
    $query = "UPDATE pelanggan SET nama_pelanggan = '$nama_pelanggan', alamat = '$alamat', no_telp = '$no_telp' WHERE id_pelanggan = '$id_pelanggan'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "Pelanggan berhasil diperbarui!";
        header("Location: ../pages/customer.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    $conn->close();
}
?>