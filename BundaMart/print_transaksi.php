<?php
include 'koneksi.php';

// Ambil data dari URL
$total_harga = $_GET["total_harga"];
$nama_produk = json_decode($_GET["nama_produk"]);
$harga_produk = json_decode($_GET["harga_produk"]);
$jumlah_beli = json_decode($_GET["jumlah_beli"]);

// Siapkan query untuk menyimpan transaksi ke dalam tabel riwayat_transaksi
$query_insert_transaksi = "INSERT INTO riwayat_transaksi (nama_produk, harga_produk, jumlah_beli, total_harga) VALUES ";

// Iterasi melalui setiap produk yang dibeli
for ($i = 0; $i < count($nama_produk); $i++) {
    // Escape string untuk mencegah SQL injection
    $nama_produk_esc = mysqli_real_escape_string($koneksi, $nama_produk[$i]);
    $harga_produk_esc = mysqli_real_escape_string($koneksi, $harga_produk[$i]);
    $jumlah_beli_esc = mysqli_real_escape_string($koneksi, $jumlah_beli[$i]);

    // Menambahkan nilai-nilai produk ke dalam query
    $query_insert_transaksi .= "('$nama_produk_esc', '$harga_produk_esc', '$jumlah_beli_esc', '$total_harga')";

    // Tambahkan koma jika produk tidak terakhir
    if ($i < (count($nama_produk) - 1)) {
        $query_insert_transaksi .= ", ";
    }
}

// Jalankan query untuk menyimpan transaksi
mysqli_query($koneksi, $query_insert_transaksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
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
    <h2>Struk Transaksi</h2>
    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Harga Produk</th>
            <th>Jumlah Beli</th>
            <th>Subtotal</th>
        </tr>
        <?php
        // Loop through each product
        for ($i = 0; $i < count($nama_produk); $i++) {
            echo "<tr>";
            echo "<td>" . $nama_produk[$i] . "</td>";
            echo "<td>Rp " . number_format($harga_produk[$i], 0, ',', '.') . "</td>";
            echo "<td>" . $jumlah_beli[$i] . "</td>";
            // Calculate subtotal for each product
            $subtotal = $harga_produk[$i] * $jumlah_beli[$i];
            echo "<td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>";
            echo "</tr>";
        }
        ?>
        <tr>
            <th>Total Harga</th>
            <td colspan="3">Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
        </tr>
    </table>
    <button onclick="window.print()">Print</button>
    <button onclick="window.location.href='kasir.php'">Kembali ke Kasir</button>
</body>
</html>
