<?php
include 'koneksi.php';

// Ambil daftar produk dari database
$query_produk = "SELECT * FROM produk";
$result_produk = mysqli_query($koneksi, $query_produk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('uploads/bg8.jpg'); /* Ganti dengan path gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.8); /* Gunakan alpha untuk efek transparansi */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            margin-right: 10px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transaksi</h1>
        <form method="POST" action="">
            <table id="tabel-transaksi">
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah Beli</th>
                </tr>
            </table>
            <button type="button" onclick="tambahBaris()">Tambah Produk</button>
            <button type="button" onclick="hitungTotal()">Total Transaksi</button>
            <button type="button" onclick="printTransaksi()">Print Transaksi</button>
            <p><strong>Total Transaksi:</strong> <span id="total-transaksi">0</span></p>
        </form>
    </div>

    <script>
        function tambahBaris() {
            var table = document.getElementById("tabel-transaksi");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            cell1.innerHTML = '<input type="text" name="nama_produk[]" required list="nama_produk_list" onchange="updateHarga(this)">';
            cell2.innerHTML = '<input type="number" name="harga_produk[]" min="0" readonly>';
            cell3.innerHTML = '<input type="number" name="jumlah_beli[]" min="1" required>';
        }

        function updateHarga(input) {
            var namaProduk = input.value;
            var row = input.parentElement.parentElement;
            var hargaProdukInput = row.cells[1].getElementsByTagName('input')[0];

            <?php
            mysqli_data_seek($result_produk, 0); // Mengembalikan pointer ke awal hasil query

            while ($row = mysqli_fetch_assoc($result_produk)) {
                echo "if (namaProduk === '" . $row['nama_produk'] . "') {";
                echo "hargaProdukInput.value = " . $row['harga_produk'] . ";";
                echo "}";
            }
            ?>
        }

        function hitungTotal() {
            var table = document.getElementById("tabel-transaksi");
            var rows = table.rows;

            var total = 0;
            for (var i = 1; i < rows.length; i++) {
                var hargaInput = rows[i].cells[1].getElementsByTagName('input')[0];
                var jumlahInput = rows[i].cells[2].getElementsByTagName('input')[0];
                var harga = parseInt(hargaInput.value);
                var jumlah = parseInt(jumlahInput.value);
                total += harga * jumlah;
            }

            document.getElementById("total-transaksi").textContent = total;
        }

        function printTransaksi() {
    var totalTransaksi = document.getElementById("total-transaksi").textContent;
    var namaProduk = [];
    var hargaProduk = [];
    var jumlahBeli = [];
    
    // Ambil data produk dari tabel
    var table = document.getElementById("tabel-transaksi");
    var rows = table.rows;
    for (var i = 1; i < rows.length; i++) {
        var namaInput = rows[i].cells[0].getElementsByTagName('input')[0];
        var hargaInput = rows[i].cells[1].getElementsByTagName('input')[0];
        var jumlahInput = rows[i].cells[2].getElementsByTagName('input')[0];
        
        namaProduk.push(namaInput.value);
        hargaProduk.push(hargaInput.value);
        jumlahBeli.push(jumlahInput.value);
    }

    // Encode product names to handle special characters
    for (var i = 0; i < namaProduk.length; i++) {
        namaProduk[i] = encodeURIComponent(namaProduk[i]);
    }

    // Konstruksi URL dengan data transaksi
    var url = 'print_transaksi.php?total_harga=' + totalTransaksi + '&nama_produk=' + JSON.stringify(namaProduk) + '&harga_produk=' + JSON.stringify(hargaProduk) + '&jumlah_beli=' + JSON.stringify(jumlahBeli);

    // Arahkan ke print_transaksi.php dengan data transaksi
    window.location.href = url;
}

    </script>
</body>
<button type="button" onclick="window.location.href='home.php'">Kembali ke Dashboard</button>

</html>