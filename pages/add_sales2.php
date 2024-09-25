<?php
session_start();
require '../config/db.php'; // Koneksi ke database

if (isset($_POST['submit'])) {
    $id_penjualan = $_POST['id_penjualan'];
    $member_status = $_POST['member_status'];
    $nama_pelanggan = $_POST['nama_pelanggan'] ?? null; // Bisa null jika non-member
    $produk = $_POST['produk'];
    $jumlah_produk = $_POST['jumlah_produk'];
    $tanggal_penjualan = date('Y-m-d'); // Atau sesuaikan format tanggal
    $total_harga = 0; // Sesuaikan logika perhitungan harga

    // Query untuk mendapatkan harga produk dari tabel produk
    $query_harga = "SELECT harga FROM produk WHERE id_produk = '$produk'";
    $result_harga = mysqli_query($koneksi, $query_harga);
    
    if ($result_harga && mysqli_num_rows($result_harga) > 0) {
        $row_harga = mysqli_fetch_assoc($result_harga);
        $harga_produk = $row_harga['harga'];
        $total_harga = $harga_produk * $jumlah_produk;
    } else {
        echo "Produk tidak ditemukan!";
        exit;
    }

    // Query untuk menyimpan data ke tabel penjualan
    $query_insert = "INSERT INTO penjualan (id_penjualan, tanggal_penjualan, total_harga, id_pelanggan)
                     VALUES ('$id_penjualan', '$tanggal_penjualan', '$total_harga', '$nama_pelanggan')";

    if (mysqli_query($koneksi, $query_insert)) {
        echo "Data berhasil disimpan!";
        header('Location: sales.php'); // Redirect jika berhasil
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>Material Dashboard 2 by Creative Tim</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
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
            width: 270px; /* Sesuaikan lebar sidebar */
            z-index: 1000; /* Pastikan sidebar berada di atas konten lainnya */
        }
        .content {
            margin-left: 270px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
            margin-top: 50px;
            flex-grow: 1; /* Mengisi sisa ruang */
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
        .table th, .table td {
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
            gap: 10px; /* Jarak antara elemen */
        }

        
        input[type="text"], input[type="number"], textarea, select {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        button[type="button"] {
            background-color: #e91e63;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 13px;
            margin: 10px;
        }
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
            event.preventDefault();
            alert("Pesanan telah ditambahkan");
            window.location.href = 'product.php';
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <?php include 'header.php'; ?>
    </div>

    <div class="content">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Sales</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-wrapper">
                            <form action="add_sales2.php" method="post">
                                <!-- ID Penjualan -->
                                <div class="mb-3">
                                    <label for="id_penjualan" class="form-label">ID Penjualan</label>
                                    <input type="text" id="id_penjualan" name="id_penjualan" required readonly>
                                </div>

                                <!-- Member / Non-member Select -->
                                <div class="mb-3">
                                    <label for="member_status" class="form-label">Status Pelanggan</label>
                                    <select id="member_status" name="member_status" class="form-select" onchange="toggleMemberInput()">
                                        <option value="non_member">Non Member</option>
                                        <option value="member">Member</option>
                                    </select>
                                </div>
                                <?php
                                    // Koneksi database
                                    include '../config/db.php';

                                    // Query untuk mengambil daftar produk
                                    $query = "SELECT id_pelanggan, nama_pelanggan FROM pelanggan";
                                    $result = mysqli_query($koneksi, $query);
                                ?>

                                <!-- Nama Pelanggan (Hanya untuk Member) -->
                                <div class="mb-3" id="member_section" style="display:none;">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <select id="nama_pelanggan" name="nama_pelanggan" class="form-select" required>
                                        <?php
                                            // Loop untuk menampilkan produk dalam dropdown
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row['id_pelanggan'] . "'>" . $row['nama_pelanggan'] . "</option>";
                                                }
                                            } else {
                                                echo "<option disabled>Tidak ada produk tersedia</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                    // Koneksi database
                                    include '../config/db.php';

                                    // Query untuk mengambil daftar produk
                                    $query = "SELECT id_produk, nama_produk FROM produk";
                                    $result = mysqli_query($koneksi, $query);
                                ?>

                             <!-- Produk yang dibeli -->
                                <div class="mb-3">
                                    <label for="produk" class="form-label">Produk</label>
                                    <select id="produk" name="produk" class="form-select" required>
                                        <?php
                                            // Loop untuk menampilkan produk dalam dropdown
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row['id_produk'] . "'>" . $row['nama_produk'] . "</option>";
                                                }
                                            } else {
                                                echo "<option disabled>Tidak ada produk tersedia</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <!-- Jumlah Produk yang Dibeli -->
                                <div class="mb-3">
                                    <label for="jumlah_produk" class="form-label">Jumlah Produk</label>
                                    <input type="number" id="jumlah_produk" name="jumlah_produk" class="form-control" required>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-pink" name="submit">Submit</button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</div>

<script>
    // Fungsi untuk menghasilkan ID Penjualan secara random
    function generateIdPenjualan() {
        const id = '00' + Math.floor(Math.random() * 1000000000);
        document.getElementById('id_penjualan').value = id;
    }

    // Tampilkan/Menyembunyikan Input Nama Pelanggan berdasarkan Member atau Non-member
    function toggleMemberInput() {
        const memberStatus = document.getElementById('member_status').value;
        const memberSection = document.getElementById('member_section');
        if (memberStatus === 'member') {
            memberSection.style.display = 'block';
        } else {
            memberSection.style.display = 'none';
        }
    }

    // Memanggil fungsi generateIdPenjualan ketika halaman dimuat
    window.onload = generateIdPenjualan;
</script>

</body>
</html>
