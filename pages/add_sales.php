<?php
session_start();
require '../config/db.php'; // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>App_kasir</title>

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
        select {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        select.form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        select.form-control:focus {
            border-color: #66afe9;
            box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
        }

        select.form-control option {
            padding: 10px;
            font-size: 14px;
            background-color: #fff;
            color: #333;
        }

        select.form-control option:hover {
            background-color: #f1f1f1;
        }

        /* For better cross-browser appearance */
        select.form-control::-ms-expand {
            display: none;
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
                echo "newSelect.innerHTML += '<option value=\"" . $plg['id_produk'] . "\" data-harga=\"" . $plg['harga'] . "\">" . $plg['nama_produk'] . " : " . number_format($plg['harga'], 2, ',', '.') . " Stok : " . $plg['stok'] . "</option>';";
            }
            ?>

            // [] sevagai array, agar bisa mengirim ke banyak server
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

        function removeProduct() {
            const container = document.getElementById('dynamic-inputs');
            const productDivs = container.querySelectorAll('.mb-3');
            if (productDivs.length > 1) { // Ensure at least one product remains
                container.removeChild(productDivs[productDivs.length - 1]);
                updateTotalPrice(); // Update the total price after removal
            }
        }

        function handleMemberTypeChange() {
            const memberType = document.getElementById('member_type').value;
            const namaPelangganField = document.getElementById('nama_pelanggan');
            const idPelangganInput = document.getElementById('id_pelanggan');
            const persenDiv = document.getElementById('persen'); // Get the persen div
            const totalHargaDiv = document.getElementById('total_harga'); // Get total harga div
            const discountDiv = document.getElementById('discount'); // Get discount div
            const totalHargaValue = document.getElementById('total_harga_value'); // Hidden input

            let totalHarga = 100000; // Contoh total harga sebelum diskon
            let discount = 0;

            console.log('Member Type Changed:', memberType);

            if (memberType === 'No-Member') {
                namaPelangganField.parentElement.style.display = 'none'; // Sembunyikan nama pelanggan
                idPelangganInput.value = '0000'; // Set ID pelanggan menjadi "0000"
                persenDiv.style.display = 'none'; // Hide discount percentage
                discount = 0; // No discount for non-member
                console.log('Non-Member selected: ID set to 0000');
            } else {
                namaPelangganField.parentElement.style.display = 'block'; // Tampilkan nama pelanggan
                idPelangganInput.value = namaPelangganField.value; // Set ID pelanggan sesuai pilihan
                persenDiv.style.display = 'block'; // Show discount percentage hanya untuk Member
                discount = totalHarga * 0.03; // 3% discount for member
                console.log('Member selected: ID set to ' + namaPelangganField.value);
            }

            // Update total harga dan discount
            const totalAfterDiscount = totalHarga - discount;
            totalHargaDiv.innerHTML = `Total Harga: Rp ${totalAfterDiscount.toFixed(2)}`;
            discountDiv.innerHTML = `Diskon: Rp ${discount.toFixed(2)}`;
            totalHargaValue.value = totalAfterDiscount; // Set hidden input value
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
                                        <input type="text" id="id_penjualan" name="id_penjualan" required readonly>
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
                                        <select name="nama_pelanggan" id="nama_pelanggan" class="form-control form-select" required>
                                            <?php
                                            $p = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                            // untuk fetch data dari database
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
                                                        echo '<option value="' . $plg['id_produk'] . '" data-harga="' . $plg['harga'] . '">' . $plg['nama_produk'] . ' : ' . number_format($plg['harga'], 2, ',', '.') . "   >   " . $plg['jumlah_satuan'] . ' ' . $plg['satuan'] . ' ( Stok : ' . $plg['stok'] . ' )</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <label for="dibeli[]">Sebanyak</label>
                                                <input type="number" name="dibeli[]" class="form-control" required oninput="updateTotalPrice()">
                                            </div>
                                        </div>
                                        <button type="button" onclick="addProduct()">Tambah Produk</button>
                                        <button type="button" onclick="removeProduct()">Hapus Produk</button> <!-- New Minus Button -->
                                    </div>

                                    <div id="total_harga">Total Harga: Rp 0.00</div>
                                    <div id="persen" style="display: none;">Potongan: 3%</div>
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