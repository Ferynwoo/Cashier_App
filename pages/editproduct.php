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
    $id = $_POST['id_produk'];
    $nama = $_POST['product_name'];
    $stok_lama = $_POST['stok_lama'];  // Stok lama dari form (readonly)
    $stok_baru = $_POST['stok_baru'];  // Stok baru yang dimasukkan
    $jumlah_satuan = $_POST['jumlah_produk'];
    $satuan = $_POST['satuan_produk'];

    // Hapus titik pemisah ribuan dan ganti koma dengan titik untuk angka desimal
    $harga = $_POST['harga'];


    // Jumlahkan stok lama dengan stok baru untuk mendapatkan total stok
    $stok_total = $stok_lama + $stok_baru;

    // Query untuk memperbarui data produk dengan stok yang dijumlahkan
    $query_update = "UPDATE produk SET 
                        nama_produk = '$nama', 
                        stok = '$stok_total', 
                        stok_lama = '$stok_lama', 
                        stok_baru = '$stok_baru', 
                        jumlah_satuan = '$jumlah_satuan', 
                        satuan = '$satuan', 
                        harga = '$harga' 
                     WHERE id_produk = '$id'";

    // Eksekusi query
    if (mysqli_query($conn, $query_update)) {
        echo "Produk berhasil diperbarui!";
    } else {
        echo "Error: " . $query_update . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    $conn->close();

    // Redirect kembali ke halaman produk
    header("Location: ../pages/product.php");
    exit();
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
        App_Cashier </title>
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
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Product</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-wrapper">
                                <!-- Form untuk edit produk -->
                                <form action="editproduct.php?id=<?php echo $data['id_produk']; ?>" method="post">
                                    <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">

                                    <label for="product_name">Nama Produk:</label>
                                    <input type="text" id="product_name" value="<?php echo $data['nama_produk']; ?>" name="product_name" required class="form-control"><br>

                                    <label for="jumlah_produk">Berat Produk:</label>
                                    <input type="number" id="jumlah_produk" value="<?php echo $data['jumlah_satuan']; ?>" name="jumlah_produk" required class="form-control"><br>

                                    <label for="satuan_produk">Satuan:</label>
                                    <select id="satuan_produk" name="satuan_produk" required class="form-control">
                                        <option value="kg" <?php echo ($data['satuan'] == 'kg') ? 'selected' : ''; ?>>Kg</option>
                                        <option value="liter" <?php echo ($data['satuan'] == 'liter') ? 'selected' : ''; ?>>Liter</option>
                                        <option value="krat" <?php echo ($data['satuan'] == 'krat') ? 'selected' : ''; ?>>Krat</option>
                                        <option value="buah" <?php echo ($data['satuan'] == 'buah') ? 'selected' : ''; ?>>Buah</option>
                                        <option value="kardus" <?php echo ($data['satuan'] == 'kardus') ? 'selected' : ''; ?>>Kardus</option>
                                        <option value="ml" <?php echo ($data['satuan'] == 'ml') ? 'selected' : ''; ?>>ML</option>
                                        <option value="sachet" <?php echo ($data['satuan'] == 'sachet') ? 'selected' : ''; ?>>Sachet</option>
                                        <option value="gram" <?php echo ($data['satuan'] == 'gram') ? 'selected' : ''; ?>>Gram</option>
                                    </select><br>

                                    <label for="harga_produk">Harga Produk:</label>
                                    <input type="number" id="harga_produk" name="harga" value="<?php echo $data['harga']; ?>" step="0.01" min="0" required class="form-control">

                                    <label for="stok_lama">Stok Lama:</label>
                                    <input type="number" id="stok_lama" value="<?php echo $data['stok']; ?>" name="stok_lama" readonly class="form-control"><br>

                                    <label for="stok_baru">Stok Baru:</label>
                                    <input type="number" id="stok_baru" name="stok_baru" value="0" required class="form-control"><br>

                                    <input type="submit" value="Perbarui Produk" class="btn btn-primary">
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