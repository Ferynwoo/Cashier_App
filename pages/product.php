<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
   App_Cashier  </title>
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
  <style>
    /* Atur sidebar */
    .sidebar {

      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      padding-top: 20px;
      overflow-y: auto; /* Tambahkan scrollbar jika diperlukan */
      z-index: 1000; /* Pastikan sidebar berada di atas konten lainnya */
    }

    /* Atur konten agar tidak tertutup oleh sidebar */
    .content {
      margin-left: 270px; /* Sesuaikan dengan lebar sidebar */
      padding: 20px;
      margin-top: 50px;
    }

    /* Jika layar kecil, buat sidebar lebih kecil */
    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }
    .content {
        margin-left: 200px;
      }
    }

    /* Styling untuk tombol */
    .btn-pink {
      background-color: #e91e63; /* Warna pink tombol */
      color: white; /* Warna teks tombol */
      border: none;
      padding: 10px 30px;
      border-radius: 0.25rem;
      cursor: pointer;
      font-size: 16px;
      margin: 10px; /* Jarak di sekitar tombol */
    }

    .btn-pink:hover {
      background-color: #d81b60; /* Warna pink lebih gelap saat hover */
    }

    .action-btn {
  padding: 5px 10px;
  margin: 0 5px;
  border-radius: 0.25rem;
  text-decoration: none; /* Menghapus garis bawah pada tautan */
  color: white; /* Warna teks */
}

.btn-edit {
  background-color: #007bff; /* Biru untuk Edit */
}

.btn-delete {
  background-color: #dc3545; /* Merah untuk Delete */
}


.action-btn:hover {
  opacity: 0.9; /* Efek hover */
}

.action-btn {
  position: relative; /* Tambahkan ini jika belum ada */
  z-index: 10; /* Atur nilai z-index yang lebih tinggi */
}


    /* Styling tabel */
    .table-wrapper {
      margin: 20px auto; /* Menempatkan wrapper di tengah secara horizontal */
      border: 1px solid #dee2e6; /* Garis tepi wrapper untuk visualisasi */
      border-radius: 0.5rem; /* Membulatkan sudut wrapper */
      max-width: 90%; /* Maksimal lebar wrapper */
    }

    .table th, .table td {
      text-align: center;
      vertical-align: middle;
      border: 1px solid #dee2e6; /* Garis tepi pada sel tabel */
    }

    .card {
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      border-bottom: 1px solid #e0e0e0;
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


  </style>
</head>

<body>
 <!-- Side Navigation -->
 <div class="sidebar">
    
    <?php include 'header.php';  ?>
    </div>
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
      ?>
  
    <!-- Side Navigation -->

    <div class="content">
  <button class="btn-pink" onclick="window.location.href='add_product.php';">
    Add
  </button>

  <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Product</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Aksi</th> <!-- Tambahkan kolom Aksi -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Ambil data dari tabel produk
                                $result = mysqli_query($conn, "SELECT * FROM produk ORDER BY created_at DESC");

                                // Loop melalui hasil dan tampilkan di tabel
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $row['id_produk'] . "</th>";
                                    echo "<td>" . $row['nama_produk'] . "</td>";
                                    echo "<td>" . $row['jumlah_satuan'] . " " . $row['satuan'] . "</td>"; // Gabungkan jumlah dan satuan
                                    echo "<td>" . number_format($row['harga'], 2, ',', '.') . "</td>";
                                    echo "<td>" . $row['stok'] . "</td>";
                                    echo "<td>
                                        <a href='editproduct.php?id=" . $row['id_produk'] . "' class='action-btn btn-edit'>Edit</a>
                                        <a href='deleteproduct.php?id=" . $row['id_produk'] . "' class='action-btn btn-delete' onclick='return confirm(\"Yakin untuk mengahapus produk?\");'>Delete</a>
                                    </td>";

                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

  <?php include 'footer.php'; ?>

</body>

</html>
