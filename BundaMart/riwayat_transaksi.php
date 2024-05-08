<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Riwayat Transaksi</h2>
    <!-- Tambahkan search bar -->
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari berdasarkan nama produk...">
    <table id="transaksiTable">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga Produk</th>
            <th>Jumlah Beli</th>
            <th>Total Harga</th>
            <th>Waktu Transaksi</th>
        </tr>
        <?php
        // 1. Include file koneksi.php untuk terhubung ke database
        include 'koneksi.php';

        // 2. Jalankan kueri SQL untuk mengambil data dari tabel histori_transaksi
        $query_transaksi = "SELECT * FROM riwayat_transaksi";
        $result_transaksi = mysqli_query($koneksi, $query_transaksi);

        // 3. Tampilkan data dalam tabel HTML
        while ($row = mysqli_fetch_assoc($result_transaksi)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nama_produk'] . "</td>";
            echo "<td>Rp " . number_format($row['harga_produk'], 0, ',', '.') . "</td>";
            echo "<td>" . $row['jumlah_beli'] . "</td>";
            echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
            echo "<td>" . $row['waktu_transaksi'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <button onclick="window.print()">Print</button>
    <button onclick="window.location.href='home.php'">Kembali ke Dashboard</button>

    <script>
        function searchTable() {
            // Deklarasi variabel
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("transaksiTable");
            tr = table.getElementsByTagName("tr");

            // Iterasi semua baris tabel, sembunyikan yang tidak sesuai dengan filter
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Kolom dengan nama produk
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
