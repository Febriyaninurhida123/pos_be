<?php
include 'koneksi.php';

// Proses tambah barang masuk jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_barang_masuk"])) {
    $nama_barang = $_POST["nama_barang"];
    $jumlah_masuk = $_POST["jumlah_masuk"];
    $harga_barang = $_POST["harga_barang"];
    $total_harga = $jumlah_masuk * $harga_barang; // Hitung total harga
    $tanggal_masuk = date("Y-m-d");

    // Query untuk menambahkan data barang masuk ke database
    $query_tambah_barang_masuk = "INSERT INTO riwayat_barang_masuk (nama_barang, jumlah_masuk, harga_barang, total_harga, tanggal_masuk) VALUES ('$nama_barang', '$jumlah_masuk', '$harga_barang', '$total_harga', '$tanggal_masuk')";
    if (mysqli_query($koneksi, $query_tambah_barang_masuk)) {
        echo "Barang berhasil ditambahkan.";
        // Refresh halaman agar data terbaru ditampilkan
        header("Refresh:0");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}


// Query untuk mendapatkan barang yang masuk
$query_barang_masuk = "SELECT * FROM riwayat_barang_masuk";
$result_barang_masuk = mysqli_query($koneksi, $query_barang_masuk);

// Query untuk mendapatkan barang yang terjual
$query_barang_terjual = "SELECT * FROM riwayat_transaksi";
$result_barang_terjual = mysqli_query($koneksi, $query_barang_terjual);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <style>
        /* CSS styles untuk desain halaman */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
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
        .button-container {
            margin-top: 20px;
        }
        .button-container button {
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-container button:hover {
            background-color: #45a049;
        }
        form {
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
        }
        form input[type="text"],
        form input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Barang</h1>

        <!-- Form tambah barang masuk -->
        <h2>Tambah Barang Masuk</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" id="nama_barang" name="nama_barang" required>
            <label for="jumlah_masuk">Jumlah:</label>
            <input type="number" id="jumlah_masuk" name="jumlah_masuk" min="1" required>
            <label for="harga_barang">Harga:</label>
            <input type="number" id="harga_barang" name="harga_barang" min="0" required>
            <button type="submit" name="submit_barang_masuk">Tambah Barang Masuk</button>
        </form>

        <!-- Tabel barang masuk -->
        <h2>Barang Masuk</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                    <th>Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Pengecekan apakah query mengembalikan hasil atau tidak
                if ($result_barang_masuk) {
                    // Tampilkan data barang masuk
                    while ($row = mysqli_fetch_assoc($result_barang_masuk)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nama_barang'] . "</td>";
                        echo "<td>" . $row['jumlah_masuk'] . "</td>";
                        echo "<td>Rp " . number_format($row['harga_barang'], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                        echo "<td>" . $row['tanggal_masuk'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data barang masuk.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tabel barang terjual -->
        <h2>Barang Terjual</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Beli</th>
                    <th>Total Harga</th>
                    <th>Waktu Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Pengecekan apakah query mengembalikan hasil atau tidak
                if ($result_barang_terjual) {
                    // Tampilkan data barang terjual
                    while ($row = mysqli_fetch_assoc($result_barang_terjual)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nama_produk'] . "</td>";
                        echo "<td>" . $row['jumlah_beli'] . "</td>";
                        echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                        echo "<td>" . $row['waktu_transaksi'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data barang terjual.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol kembali -->
        <div class="button-container">
            <button onclick="window.location.href='laporan.php'">Kembali ke Dashboard Laporan</button>
        </div>
    </div>
</body>
</html>
