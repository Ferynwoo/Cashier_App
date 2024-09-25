<?php
session_start();
require 'config/db.php'; // Koneksi ke database
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest'; // Default to 'guest' jika belum di-set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <title>Cashier Dashboard</title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <style>
        /* Menyembunyikan elemen dengan class 'd-none' */
        .d-none {
            display: none;
        }
        .bg-gradient-dark-purple {
    background: linear-gradient(87deg, #4B0082 0%, #2e0047 100%);
}

    </style>
</head>
<body class="g-sidenav-show bg-gray-100">
    <!-- Sidebar -->
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="https://demos.creative-tim.com/material-dashboard/pages/dashboard" target="_blank">
                <span class="ms-1 font-weight-bold text-white">Cashier App</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <!-- Account Pages -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account Pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="pages/login.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">login</i>
                        </div>
                        <span class="nav-link-text ms-1">Log In</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="main-content border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 position-relative z-index-2">
                    <!-- Dashboard Content -->
                    <div class="content">
                        <div class="container-fluid py-4">
                            <div class="row">
                                <div class="col-lg-12 position-relative z-index-2">
                                    <!-- Dashboard Header -->
                                    <div class="card card-plain mb-4">
                                        <div class="card-body p-3">
                                            <h2 class="font-weight-bolder mb-0">Dashboard</h2>
                                        </div>
                                    </div>
                                    <!-- Flexbox for Cards -->
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <!-- Card: Total Pelanggan -->
                                        <div class="card mb-2 mx-2" style="flex: 1; min-width: 200px;">
                                            <div class="card-header p-3 pt-2">
                                                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                                    <i class="material-icons opacity-10">weekend</i>
                                                </div>
                                                <div class="text-end pt-1">
                                                    <p class="text-sm mb-0 text-capitalize">Total Pelanggan</p>
                                                    <h4 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pelanggan")); ?></h4>
                                                </div>
                                            </div>
                                            <hr class="dark horizontal my-0">
                                        </div>
                                        <!-- Card: Total Produk -->
                                        <div class="card mb-2 mx-2" style="flex: 1; min-width: 200px;">
                                            <div class="card-header p-3 pt-2">
                                                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                                    <i class="material-icons opacity-10">leaderboard</i>
                                                </div>
                                                <div class="text-end pt-1">
                                                    <p class="text-sm mb-0 text-capitalize">Total Produk</p>
                                                    <h4 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM produk")); ?></h4>
                                                </div>
                                            </div>
                                            <hr class="dark horizontal my-0">
                                            <div class="card-footer p-3">
                                                
                                            </div>
                                        </div>
                                        <!-- Card: Total Pembelian -->
                                        <div class="card mb-2 mx-2" style="flex: 1; min-width: 200px;">
                                            <div class="card-header p-3 pt-2 bg-transparent">
                                                <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                                    <i class="material-icons opacity-10">store</i>
                                                </div>
                                                <div class="text-end pt-1">
                                                    <p class="text-sm mb-0 text-capitalize">Total Pembelian</p>
                                                    <h4 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM penjualan")); ?></h4>
                                                </div>
                                            </div>
                                            <hr class="horizontal my-0 dark">
                                        </div>
                                        <!-- Card: Total User -->
                                        <div class="card mb-2 mx-2" style="flex: 1; min-width: 200px;">
                                            <div class="card-header p-3 pt-2 bg-transparent">
                                            <div class="icon icon-lg icon-shape bg-gradient-dark-purple shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                                <i class="material-icons opacity-10">person</i>
                                            </div>
                                                <div class="text-end pt-1">
                                                    <p class="text-sm mb-0 text-capitalize">Total User</p>
                                                    <h4 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users")); ?></h4>
                                                </div>
                                            </div>
                                            <hr class="horizontal my-0 dark">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Dashboard Content -->
                </div>
            </div>
        </div>
    </main>
    <!-- End of Main Content -->
    
    <script>
        // Function to check user role and show/hide menu items accordingly
        function checkUserRole() {
            const role = '<?php echo $role; ?>';
            document.getElementById('register').classList.toggle('d-none', role !== 'admin');
            document.getElementById('log-out').classList.toggle('d-none', role === 'guest');
        }

        document.addEventListener('DOMContentLoaded', checkUserRole);
    </script>
</body>
</html>
