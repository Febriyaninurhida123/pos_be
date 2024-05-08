<?php
include 'koneksi.php';

// Tangkap nilai rentang waktu yang dipilih
$start_date = $_GET['start_date'] ?? date('Y-m-01'); // Nilai default: awal bulan ini
$end_date = $_GET['end_date'] ?? date('Y-m-t'); // Nilai default: akhir bulan ini

// Laporan Penjualan
$query_penjualan = "SELECT t.*, (t.jumlah_beli * (t.harga_produk - b.harga_barang)) AS keuntungan FROM riwayat_transaksi t INNER JOIN riwayat_barang_masuk b ON t.nama_produk = b.nama_barang WHERE t.waktu_transaksi BETWEEN '$start_date' AND '$end_date'";
$result_penjualan = mysqli_query($koneksi, $query_penjualan);

// Periksa hasil query
if (!$result_penjualan) {
    die("Query error: " . mysqli_error($koneksi));
}

// Hitung total penjualan dan keuntungan
$total_penjualan = 0;
$total_keuntungan = 0;
while ($row = mysqli_fetch_assoc($result_penjualan)) {
    $total_penjualan += $row['total_harga'];
    $total_keuntungan += $row['keuntungan'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
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
        h2 {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Penjualan</h1>
        <form action="" method="GET">
            <label for="start_date">Tanggal Awal:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
            <label for="end_date">Tanggal Akhir:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
            <button type="submit">Tampilkan</button>
        </form>
        <h2>Total Penjualan</h2>
        <p>Total penjualan dari <?php echo $start_date; ?> sampai <?php echo $end_date; ?>: Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></p>
        <h2>Total Keuntungan</h2>
        <p>Total keuntungan dari <?php echo $start_date; ?> sampai <?php echo $end_date; ?>: Rp <?php echo number_format($total_keuntungan, 0, ',', '.'); ?></p>
        <table>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Produk</th>
                <th>Harga Produk</th>
                <th>Jumlah Beli</th>
                <th>Total Harga</th>
                <th>Keuntungan</th>
                <th>Waktu Transaksi</th>
            </tr>
            <?php
            // Mulai ulang hasil query
            mysqli_data_seek($result_penjualan, 0);
            while ($row = mysqli_fetch_assoc($result_penjualan)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nama_produk'] . "</td>";
                echo "<td>Rp " . number_format($row['harga_produk'], 0, ',', '.') . "</td>";
                echo "<td>" . $row['jumlah_beli'] . "</td>";
                echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                echo "<td>Rp " . number_format($row['keuntungan'], 0, ',', '.') . "</td>";
                echo "<td>" . $row['waktu_transaksi'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <button onclick="window.location.href='laporan.php'">Kembali</button>

    </div>
</body>
</html>
