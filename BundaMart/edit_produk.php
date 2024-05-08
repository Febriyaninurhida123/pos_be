<?php
include 'koneksi.php'; // Sertakan file koneksi.php untuk menginisialisasi koneksi ke database

// Ambil ID produk dari parameter URL
$id_produk = $_GET['id_produk'];

// Query untuk mendapatkan detail produk berdasarkan ID
$query = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
$result = mysqli_query($koneksi, $query);

// Periksa apakah produk ditemukan
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_produk = $row['nama_produk'];
    $harga_produk = $row['harga_produk'];
    $stok_produk = $row['stok_produk'];
} else {
    echo "Produk tidak ditemukan.";
    exit();
}

// Jika tombol "Simpan" ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Tangkap data yang dikirimkan dari form
    $nama_produk_baru = $_POST["nama_produk"];
    $harga_produk_baru = $_POST["harga_produk"];
    $stok_produk_baru = $_POST["stok_produk"];

    // Query untuk mengupdate data produk di database
    $query_update = "UPDATE produk SET nama_produk = '$nama_produk_baru', harga_produk = '$harga_produk_baru', stok_produk = '$stok_produk_baru' WHERE id_produk = '$id_produk'";

    // Jalankan query update
    if (mysqli_query($koneksi, $query_update)) {
        echo "Produk berhasil diperbarui.";
        // Redirect kembali ke halaman kelola_produk.php setelah berhasil menyimpan
        header("Location: kelola_produk.php");
        exit();
    } else {
        echo "Error: " . $query_update . "<br>" . mysqli_error($koneksi);
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
    <title>Edit Produk</title>
</head>
<body>
    <h1>Edit Produk</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_produk=' . $id_produk; ?>">
        <label for="nama_produk">Nama Produk:</label><br>
        <input type="text" id="nama_produk" name="nama_produk" value="<?php echo $nama_produk; ?>" required><br><br>

        <label for="harga_produk">Harga:</label><br>
        <input type="number" id="harga_produk" name="harga_produk" value="<?php echo $harga_produk; ?>" min="0" required><br><br>

        <label for="stok_produk">Stok:</label><br>
        <input type="number" id="stok_produk" name="stok_produk" value="<?php echo $stok_produk; ?>" min="0" required><br><br>

        <input type="submit" name="submit" value="Simpan">
    </form>
</body>
</html>
