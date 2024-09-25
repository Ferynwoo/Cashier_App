<!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Detail Penjualan</h2>
            <div id="saleDetails"></div>

            <!-- Input untuk pembayaran -->
            <label for="paid_amount">Bayar :</label>
            <input type="number" id="paid_amount" placeholder="Masukkan nominal pembayaran" value="0" />
            <button onclick="calculateChange()">Kembalian</button>

            <p id="changeAmount"></p>

            <!-- Area untuk menampilkan nominal pembayaran dan kembalian di bagian bawah -->
            <div id="paymentSummary">
                <p><strong>Nominal yang Dibayarkan:</strong> <span id="paidDisplay">0</span></p>
                <p><strong>Kembalian:</strong> <span id="changeDisplay">0.00</span></p>
            </div>

            <!-- Tombol untuk menyelesaikan transaksi -->
            <button id="finishButton" onclick="finishTransaction()">Selesaikan Transaksi</button>

        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal
        function openModal(id_penjualan) {
            document.getElementById("myModal").style.display = "block";

            // Mengambil detail pembelian dari server
            fetch("getdetail.php?id_penjualan=" + id_penjualan)
                .then(response => response.text())
                .then(html => {
                    document.getElementById("saleDetails").innerHTML = html;
                });
        }

        // Tutup modal
        document.querySelector(".close").onclick = function () {
            document.getElementById("myModal").style.display = "none";
        }

        // Fungsi untuk menghitung kembalian
        function calculateChange() {
            const total = parseFloat(document.getElementById("total").value); // Pastikan total ada di input hidden
            const paid = parseFloat(document.getElementById("paid_amount").value);

            // Reset hasil yang sebelumnya
            document.getElementById("changeAmount").innerHTML = "";
            document.getElementById("paidDisplay").textContent = "";
            document.getElementById("changeDisplay").textContent = "";

            if (!isNaN(paid) && paid >= total) {
                const change = paid - total;
                document.getElementById("changeAmount").innerHTML = "Kembalian: " + change.toFixed(2);

                // Tampilkan di bagian bawah
                document.getElementById("paidDisplay").textContent = paid.toFixed(2);
                document.getElementById("changeDisplay").textContent = change.toFixed(2);
            } else {
                document.getElementById("changeAmount").innerHTML = "Nominal yang dibayarkan tidak cukup!";
            }
        }

        // Mengambil total dari input tersembunyi dan menampilkannya di modal
const totalHidden = document.getElementById('total_hidden').value;
document.getElementById('total').value = totalHidden;


// Fungsi untuk menghitung kembalian
function calculateChange() {
    const total = parseFloat(document.getElementById("total").value); // Ambil total dari input yang diperbarui
    const paid = parseFloat(document.getElementById("paid_amount").value);

    document.getElementById("changeAmount").innerHTML = "";
    document.getElementById("paidDisplay").textContent = "";
    document.getElementById("changeDisplay").textContent = "";

    if (!isNaN(paid) && paid >= total) {
        const change = paid - total;
        document.getElementById("changeAmount").innerHTML = "Kembalian: " + change.toFixed(2);

        document.getElementById("paidDisplay").textContent = paid.toFixed(2);
        document.getElementById("changeDisplay").textContent = change.toFixed(2);
    } else {
        document.getElementById("changeAmount").innerHTML = "Nominal yang dibayarkan tidak cukup!";
    }
}

        // Fungsi untuk menyelesaikan transaksi
        function finishTransaction() {
            const id_penjualan = document.getElementById("total").dataset.idPenjualan;
            const total = parseFloat(document.getElementById("total").value);
            const paid = parseFloat(document.getElementById("paid_amount").value);
            const change = parseFloat(document.getElementById("changeDisplay").textContent);

            fetch('simpanpenjualan.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id_penjualan: id_penjualan,
                    total: total,
                    bayar: paid,
                    kembalian: change,
                    status_transaksi: 'selesai'
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Transaksi selesai! Pembayaran: ${paid.toFixed(2)}, Kembalian: ${change.toFixed(2)}`);
                        document.getElementById("finishButton").disabled = true;
                        document.getElementById("paid_amount").disabled = true;
                    } else {
                        alert("Gagal menyimpan transaksi: " + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <style>
        #myModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            background-color: #e91e63;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            display: inline-block;
        }

        button:hover {
            background-color: #c2185b;
        }
    </style>
