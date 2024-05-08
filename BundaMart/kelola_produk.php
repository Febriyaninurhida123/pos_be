<?php
include 'koneksi.php'; // Menyertakan file koneksi.php untuk menginisialisasi koneksi ke database

// Pastikan koneksi sukses sebelum menjalankan kueri SQL
if ($koneksi) {
    // Lakukan kueri SQL
    $query = "SELECT * FROM produk";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Lakukan iterasi hasil kueri dan tampilkan data
        while ($row = mysqli_fetch_assoc($result)) {
            // Tampilkan data produk di sini
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Koneksi ke database gagal.";
}

// Cek jika tombol submit untuk menambah produk ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_produk"])) {
    // Tangkap data yang dikirimkan dari form
    $nama_produk = $_POST["nama_produk"];
    $harga_produk = $_POST["harga_produk"];
    $stok_produk = $_POST["stok_produk"];

    // Lakukan validasi atau sanitasi data jika diperlukan

    // Query untuk menambahkan produk ke database
    $sql = "INSERT INTO produk (nama_produk, harga_produk, stok_produk) VALUES ('$nama_produk', '$harga_produk', '$stok_produk')";

    // Jalankan query
    if (mysqli_query($koneksi, $sql)) {
        echo "Produk berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Cek jika tombol submit untuk menghapus produk ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hapus_produk"])) {
    // Tangkap id produk yang akan dihapus
    $id_produk = $_POST["id_produk"];

    // Query untuk menghapus produk dari database
    $sql = "DELETE FROM produk WHERE id_produk = $id_produk";

    // Jalankan query
    if (mysqli_query($koneksi, $sql)) {
        echo "Produk berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Tutup koneksi setelah selesai menggunakan
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
</head>
<body>
    <h1>Kelola Produk</h1>

    <!-- Tombol untuk kembali ke dashboard.php -->
    <!-- Form untuk menambah produk -->
    <h2>Tambah Produk</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nama_produk">Nama Produk:</label><br>
        <input type="text" id="nama_produk" name="nama_produk" required><br><br>

        <label for="harga_produk">Harga:</label><br>
        <input type="number" id="harga_produk" name="harga_produk" min="0" required><br><br>

        <label for="stok_produk">Stok:</label><br>
        <input type="number" id="stok_produk" name="stok_produk" min="0" required><br><br>

        <input type="submit" name="submit_produk" value="Tambah Produk">
    </form>

    <!-- Daftar produk yang ada -->
    <h2>Daftar Produk</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Buka koneksi kembali sebelum menjalankan query
        include 'koneksi.php';
        $sql = "SELECT * FROM produk";
        $result = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output data dari setiap baris
            while($row = mysqli_fetch_assoc($result)) {
                $id_produk = $row["id_produk"];
                $nama_produk = $row["nama_produk"];
                $harga_produk = $row["harga_produk"];
                $stok_produk = $row["stok_produk"];

                // Ambil total barang yang masuk dari riwayat barang masuk untuk produk ini
                $sql_total_masuk = "SELECT SUM(jumlah_masuk) AS total_masuk FROM riwayat_barang_masuk WHERE nama_barang = '$nama_produk'";
                $result_total_masuk = mysqli_query($koneksi, $sql_total_masuk);
                $row_total_masuk = mysqli_fetch_assoc($result_total_masuk);
                $total_masuk = $row_total_masuk["total_masuk"];

                // Tambahkan jumlah barang yang masuk ke stok
                $stok_tersedia = $stok_produk + $total_masuk;

                // Tampilkan produk dan stok tersedia
                echo "<tr>";
                echo "<td>" . $id_produk . "</td>";
                echo "<td>" . $nama_produk . "</td>";
                echo "<td>" . $harga_produk . "</td>";
                echo "<td>" . $stok_tersedia . "</td>";
                echo "<td>
                        <form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                            <input type='hidden' name='id_produk' value='" . $id_produk . "'>
                            <input type='submit' name='hapus_produk' value='Hapus'>
                        </form>
                        <form method='GET' action='edit_produk.php'>
                            <input type='hidden' name='id_produk' value='" . $id_produk . "'>
                            <input type='submit' value='Edit'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada produk.</td></tr>";
        }
        ?>
    </table>
    
    <a href="home.php">Kembali ke Dashboard</a>

</body>
</html>
