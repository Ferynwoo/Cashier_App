<?php
session_start();
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


  <style>
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      padding-top: 20px;
      overflow-y: auto;
      /* Tambahkan scrollbar jika diperlukan */
      z-index: 1000;
      /* Pastikan sidebar berada di atas konten lainnya */
    }

    /* Atur konten agar tidak tertutup oleh sidebar */
    .content {
      margin-left: 270px;
      /* Sesuaikan dengan lebar sidebar */
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

    /* Styling untuk table-wrapper */
    .table-wrapper {
      margin: 20px auto;
      /* Menempatkan wrapper di tengah secara horizontal */
      border: 1px solid #dee2e6;
      /* Garis tepi wrapper untuk visualisasi */
      border-radius: 0.5rem;
      /* Membulatkan sudut wrapper */
      max-width: 90%;
      /* Maksimal lebar wrapper */
      overflow-x: auto;
      /* Scroll horizontal jika diperlukan */
    }

    /* Styling untuk table */
    .table {
      border-collapse: collapse;
      width: 100%;
    }

    .table th,
    .table td {
      text-align: center;
      vertical-align: middle;
      border: 1px solid #dee2e6;
      /* Garis tepi pada sel tabel */
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

    /* Styling untuk form */
    form {
      padding: 20px;
      border-radius: 0.5rem;
      max-width: 100%;
      /* Maksimal lebar form */
      margin-top: 20px;
      /* Jarak di atas form */
    }

    /* Styling untuk label */
    .form-label {
      display: block;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }

    /* Styling untuk input dan textarea */
    input[type="text"],
    input[type="number"],
    textarea {
      border: 1px solid #dee2e6;
      border-radius: 0.25rem;
      padding: 10px;
      font-size: 16px;
      width: 100%;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    /* Styling untuk tombol submit */
    button[type="submit"] {
      background-color: #e91e63;
      /* Warna pink tombol */
      color: white;
      /* Warna teks tombol */
      border: none;
      padding: 10px 30px;
      border-radius: 0.25rem;
      cursor: pointer;
      font-size: 16px;
      margin: 10px;
      /* Jarak di sekitar tombol */
    }

    button[type="submit"]:hover {
      background-color: #d81b60;
      /* Warna pink lebih gelap saat hover */

    }

    /* Responsif untuk layar lebih kecil */
    @media (max-width: 768px) {
      .content {
        margin-left: 0;
        padding: 10px;
      }

      .table-wrapper {
        overflow-x: scroll;
        /* Aktifkan scroll pada layar kecil */
      }

      form {
        margin-top: 20px;
        /* Jarak atas form pada layar kecil */
      }
    }

    .form-row {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      /* Jarak antar elemen */
    }

    .form-group {
      flex: 1;
      /* Membuat elemen di dalam flex tumbuh proporsional */
      min-width: 0;
      /* Mengizinkan elemen mengecil lebih kecil dari lebar default */
    }

    select {
      width: 100%;
      z-index: 11;
      /* Pastikan dropdown berada di atas elemen lain */
      position: relative;
      /* Untuk mematuhi aturan z-index */
    }

    /* Styling untuk tombol */
    .btn-pink {
      background-color: #e91e63;
      /* Warna pink tombol */
      color: white;
      /* Warna teks tombol */
      border: none;
      padding: 10px 30px;
      border-radius: 0.25rem;
      cursor: pointer;
      font-size: 16px;
      margin: 10px;
      /* Jarak di sekitar tombol */
    }

    .btn-pink:hover {
      background-color: #d81b60;
      /* Warna pink lebih gelap saat hover */
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
    <button class="btn-pink" onclick="window.location.href='product.php';">
      Kembali
    </button>
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
                <!-- Form untuk menambah produk -->
                <form action="../config/addproduct.php" method="post">
                  <!-- Input Nama Produk -->
                  <label for="nama_produk">Nama Produk:</label>
                  <input type="text" id="product_name" name="product_name" required class="form-control"><br>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="jumlah_produk">Jumlah Satuan:</label>
                      <input type="number" id="jumlah_produk" name="jumlah_produk" required class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="satuan_produk">Satuan:</label>
                      <select id="satuan_produk" name="satuan_produk" class="form-control" required>
                        <option value="kg">Kg</option>
                        <option value="liter">Liter</option>
                        <option value="krat">Krat</option>
                        <option value="buah">Buah</option>
                        <option value="kardus">Kardus</option>
                        <option value="ml">ML</option>
                        <option value="sachet">Sachet</option>
                        <option value="gram">Gram</option>
                      </select>
                    </div>
                  </div>

                  <!-- Input Harga Produk -->
                  <label for="harga_produk">Harga Produk:</label>
                  <input type="number" id="product_price" step="0.01" name="harga" required class="form-control"><br>

                  <!-- Input Stok Produk -->
                  <label for="stok">Stok Produk:</label>
                  <input type="number" id="stok" name="stok" required class="form-control"><br>


                  <br>

                  <!-- Tombol Tambah Produk -->
                  <input type="submit" value="Tambah Produk" class="btn btn-primary">
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