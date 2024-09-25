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
    $query = mysqli_query($conn, "SELECT * FROM penjualan WHERE id_penjualan = '$id'");

    // Cek apakah produk ditemukan
    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query); // Data produk ditemukan
    } else {
        echo "Penjualan tidak ditemukan!";
        exit(); // Hentikan eksekusi jika produk tidak ditemukan
    }
} else {
    echo "ID penjualan tidak ditemukan!";
    exit(); // Hentikan eksekusi jika ID tidak ada
}

// Ambil data dari form
$id = $data['id_penjualan'];
$member = $_POST['id_pelanggan'] ?? '0000'; // Set default untuk non-member
$total_harga = $_POST['total_harga'];
$produk_ids = $_POST['satuan_produk'] ?? [];
$jumlah_produk = $_POST['dibeli'] ?? [];

// Hapus titik pemisah ribuan dan ganti koma dengan titik untuk angka desimal
$harga = str_replace('.', '', $_POST['harga']);
$harga = str_replace(',', '.', $harga);

// Ambil data produk untuk stok dan harga
foreach ($produk_ids as $index => $produk_id) {
    $produk_query = mysqli_query($conn, "SELECT stok, harga FROM produk WHERE id_produk = '$produk_id'");
    if ($produk_query && mysqli_num_rows($produk_query) > 0) {
        $produk_data = mysqli_fetch_assoc($produk_query);
        $stok = $produk_data['stok'];
        $harga = $produk_data['harga'];
        // Lakukan logika update sesuai kebutuhan Anda
    }
}

// Query untuk memperbarui data penjualan
$query = "UPDATE penjualan SET id_pelanggan = '$member', total_harga = '$total_harga' WHERE id_penjualan = '$id'";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    echo "Penjualan berhasil diperbarui!";
    // Redirect kembali ke halaman produk
    header("Location: editsales.php=$id");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

// Tutup koneksi
$conn->close();

    // Redirect kembali ke halaman produk
    header("Location: sales.php");
    exit();
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
        function generateIdPenjualan() {
            const id = '00' + Math.floor(Math.random() * 1000000000);
            document.getElementById('id_penjualan').value = id;
        }
        window.onload = generateIdPenjualan;

        function addProduct() {
            const container = document.getElementById('dynamic-inputs');
            const newProductDiv = document.createElement('div');
            newProductDiv.classList.add('mb-3');

            const newSelect = document.createElement('select');
            newSelect.name = 'satuan_produk[]';
            newSelect.classList.add('form-control');
            newSelect.required = true;

            <?php
            $p = mysqli_query($koneksi, "SELECT * FROM produk");
            while ($plg = mysqli_fetch_assoc($p)) {
                echo "newSelect.innerHTML += '<option value=\"" . $plg['id_produk'] . "\" data-harga=\"" . $plg['harga'] . "\">" . $plg['nama_produk'] . " : " . $plg['harga'] . "</option>';";
            }
            ?>

            const newInput = document.createElement('input');
            newInput.type = 'number';
            newInput.name = 'dibeli[]';
            newInput.classList.add('form-control');
            newInput.required = true;

            newInput.oninput = function() {
                updateTotalPrice();
            };

            newProductDiv.appendChild(newSelect);
            newProductDiv.appendChild(newInput);
            container.appendChild(newProductDiv);
        }


        function updateTotalPrice() {
            let totalHarga = 0;
            const productInputs = document.querySelectorAll('#dynamic-inputs div');
            productInputs.forEach(div => {
                const select = div.querySelector('select');
                const input = div.querySelector('input');
                const harga = select.options[select.selectedIndex].getAttribute('data-harga');
                const quantity = input.value;
                if (quantity) {
                    totalHarga += harga * quantity;
                }
            });

            const discount = calculateDiscount(totalHarga);
            const finalPrice = totalHarga - discount;

            document.getElementById('total_harga').textContent = "Total Harga: Rp " + finalPrice.toFixed(2);
            document.getElementById('total_harga_value').value = finalPrice;
            document.getElementById('discount').textContent = "Diskon: Rp " + discount.toFixed(2);
        }

        function calculateDiscount(totalHarga) {
            const memberType = document.getElementById('member_type').value;
            let discount = 0;
            if (memberType === 'Member') {
                discount = totalHarga * 0.03; // Diskon 3%
            }
            return discount;
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
                                <form action="../config/addsales.php" method="post">
                                    <div class="mb-3">
                                        <label for="id_penjualan" class="form-label">ID Penjualan</label>
                                        <input type="text" id="id_penjualan" name="id_penjualan" value="<?php echo $data['id_penjualan']; ?>" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="member_type" class="form-label">Member or No-Member?</label>
                                        <select name="member_type" id="member_type" onchange="handleMemberTypeChange(); updateTotalPrice()" required>
                                            <option value="Member">Member</option>
                                            <option value="No-Member">No-Member</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                    <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="">
                                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                        <select name="nama_pelanggan" id="nama_pelanggan"  class="form-control form-select" required>
                                            <?php
                                            $p = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                            while ($plg = mysqli_fetch_assoc($p)) {
                                                echo '<option value="' . $plg['id_pelanggan'] . '">' . $plg['nama_pelanggan'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label for="nama_produk" class="form-label">Pilih Produk</label>
                                        <div id="dynamic-inputs">
                                            <div class="mb-3">
                                                <select name="satuan_produk[]" class="form-control" required>
                                                    <?php
                                                    $p = mysqli_query($koneksi, "SELECT * FROM produk");
                                                    while ($plg = mysqli_fetch_assoc($p)) {
                                                        echo '<option value="' . $plg['id_produk'] . '" data-harga="' . $plg['harga'] . '">' . $plg['nama_produk'] . ' : ' . $plg['harga'] . ' Stok : ' . $plg ['stok'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input type="number" name="dibeli[]" class="form-control" required oninput="updateTotalPrice()">
                                            </div>
                                        </div>
                                        <button type="button" onclick="addProduct()">Tambah Produk</button>
                                    </div>

                                    <div id="total_harga">Total Harga: Rp 0.00</div>
                                    <div id="discount">Diskon: Rp 0.00</div>
                                    <input type="hidden" id="total_harga_value" name="total_harga">

                                    <button type="submit" name="submit">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>