<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_baru";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menghasilkan id_pelanggan secara acak
$id_pelanggan = mt_rand(1000, 9999); // ID random 4 digit

// Mengambil data dari form
$nama_pelanggan = $_POST['nama_pelanggan'];
$alamat = $_POST['alamat'];
$no_telp = $_POST['no_telp'];

// Menyimpan data ke database
$sql = "INSERT INTO Pelanggan (id_pelanggan, nama_pelanggan, alamat, no_telp) VALUES ('$id_pelanggan', '$nama_pelanggan', '$alamat', '$no_telp')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Customer telah ditambahkan');
            window.location.href = '../pages/customer.php';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
