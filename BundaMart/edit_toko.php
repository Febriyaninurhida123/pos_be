<?php
include 'koneksi.php'; // Menghubungkan ke file koneksi.php

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Memeriksa apakah ID toko diberikan melalui parameter GET
if (!isset($_GET['id'])) {
    // Jika tidak, arahkan kembali ke halaman sebelumnya
    header("Location: kelola_toko.php");
    exit();
}

$id = $_GET['id'];

// Proses pembaruan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $nama_toko = clean_input($_POST["nama_toko"]);
    $alamat_toko = clean_input($_POST["alamat_toko"]);
    $telepon_toko = clean_input($_POST["telepon_toko"]);

    $sql = "UPDATE info_toko SET nama_toko='$nama_toko', alamat_toko='$alamat_toko', telepon_toko='$telepon_toko' WHERE id=$id";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Query untuk mendapatkan data info toko berdasarkan ID
$query = "SELECT * FROM info_toko WHERE id=$id";
$result = mysqli_query($koneksi, $query);

// Memeriksa apakah query berhasil dieksekusi
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

// Memeriksa apakah ID toko yang diberikan melalui parameter GET valid
if (mysqli_num_rows($result) == 0) {
    // Jika tidak, arahkan kembali ke halaman sebelumnya
    header("Location: kelola_toko.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Toko</title>
</head>
<body>
    <h1>Edit Info Toko</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>">
        <label for="nama_toko">Nama Toko:</label><br>
        <input type="text" id="nama_toko" name="nama_toko" value="<?php echo $row['nama_toko']; ?>" required><br><br>
        <label for="alamat_toko">Alamat Toko:</label><br>
        <input type="text" id="alamat_toko" name="alamat_toko" value="<?php echo $row['alamat_toko']; ?>" required><br><br>
        <label for="telepon_toko">Telepon Toko:</label><br>
        <input type="text" id="telepon_toko" name="telepon_toko" value="<?php echo $row['telepon_toko']; ?>" required><br><br>
        <input type="submit" name="submit" value="Perbarui">
    </form>
    <br>
    <a href="kelola_toko.php">Kembali</a>
</body>
</html>
