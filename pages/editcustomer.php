<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_baru";

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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    App_Cashier
  </title>
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <!-- Select2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding-top: 20px;
            overflow-y: auto;
            width: 270px;
            z-index: 1000;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            margin-top: 50px;
            flex-grow: 1;
        }

        .table-wrapper {
            margin: 20px auto;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            max-width: 90%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #009688 0, #00796b 100%);
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        form {
            padding: 20px;
            border-radius: 0.5rem;
            max-width: 100%;
            margin-top: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        button[type="button"],
        button[type="submit"] {
            background-color: #e91e63;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }

        button[type="submit"]:hover {
            background-color: #d81b60;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 10px;
            }

            .table-wrapper {
                overflow-x: scroll;
            }
        }
    </style>

  <script>
    function showAlertAndRedirect(event) {
      event.preventDefault(); // Mencegah pengiriman form secara langsung
      alert("Pesanan telah ditambahkan"); // Menampilkan alert pop-up
      window.location.href = 'product.php'; // Mengarahkan ke halaman produk.php
    }
  </script>
</head>

<body>
<div class="sidebar">
    
    <?php include 'header.php';  ?>
    </div>

    <div class="content">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header bg-gradient-primary">
                            <h6 class="text-white">Edit Customer</h6>
                        </div>
                        <div class="card-body">
                            <!-- Form untuk edit pelanggan -->
                            <form action="editcustomer.php?id=<?php echo $id; ?>" method="post">
                                <input type="hidden" name="id_pelanggan" value="<?php echo $id; ?>">
                                <div class="mb-3">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="<?php echo $data['nama_pelanggan']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" rows="3" required><?php echo $data['alamat']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">No Telp</label>
                                    <input type="number" id="no_telp" name="no_telp" value="<?php echo $data['no_telp']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-pink">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

  </div>

  <?php include 'footer.php'; ?>

</body>

</html>
