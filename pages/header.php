<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Memulai session hanya jika belum ada session yang aktif
}
require '../config/db.php'; // Koneksi ke database
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest'; // Cek apakah session 'role' sudah diset, jika belum default ke 'guest'



// Get the current page title
$currentPage = basename($_SERVER['PHP_SELF'], ".php");
$pageTitle = ucfirst($currentPage); // Capitalize the first letter
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>Cashier</title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }
    .sidenav {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px; /* Sesuaikan lebar sesuai kebutuhan */
      height: 100vh;
      background: #343a40;
      color: white;
      overflow-x: hidden;
      padding-top: 20px;
      z-index: 1000; /* Pastikan sidenav berada di atas konten lainnya */
    }
    .main-content {
      margin-left: 250px; /* Sesuaikan dengan lebar sidenav */
      padding: 20px;
      overflow-x: auto; /* Agar konten tidak terpotong jika terlalu lebar */
    }
    .navbar-main {
    position: fixed;
    top: 0;
    left: 250px;
    width: calc(81% ); /* Sesuaikan dengan lebar sidenav */
    z-index: 10000; /* Pastikan navbar berada di atas konten lainnya */
    background-color: #fff; /* Atur warna latar belakang navbar */
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#">
            <span class="ms-1 font-weight-bold text-white">Cashier App</span>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="dashboard.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="customer.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Customers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="product.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Product</span>
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-white" href="sales.php">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">table_view</i>
                </div>
                <span class="nav-link-text ms-1">Sales</span>
            </a>
        </li>

        <!-- Account Pages -->
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li>
            <?php if ($role === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="register.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person_add</i>
                    </div>
                    <span class="nav-link-text ms-1">Create New Account</span>
                </a>
            </li>
            <?php endif; ?>

            
            <?php if ($role === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="user.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">User</span>
                </a>
            </li>
            <?php endif; ?>


            <li class="nav-item">
                <a class="nav-link text-white" href="logout.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i>
                    </div>
                    <span class="nav-link-text ms-1">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<main class="main-content border-radius-lg ">
        <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
        
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
            <?php echo $pageTitle; ?>
        </li>
    </ol>
        <h6 class="font-weight-bolder mb-0"><?php echo $pageTitle; ?></h6>
        
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
    

    </div>
    </nav>
    <!-- End Navbar -->
</main>

<!-- Optional JavaScript for role-checking (debugging purposes) -->
<script>
    // Fungsi untuk mengecek role pengguna (dapat dihapus jika tidak diperlukan)
    function checkUserRole() {
        const role = '<?php echo $role; ?>';
        console.log('Role pengguna: ' + role); // Ini akan mencetak role pengguna di console
    }

    // Panggil fungsi saat halaman selesai dimuat (untuk keperluan debugging)
    document.addEventListener('DOMContentLoaded', checkUserRole);
</script>

</body>
</html>
