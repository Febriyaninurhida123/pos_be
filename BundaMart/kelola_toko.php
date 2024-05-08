<?php
include 'koneksi.php'; // Menghubungkan ke file koneksi.php

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses penambahan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $nama_toko = clean_input($_POST["nama_toko"]);
    $alamat_toko = clean_input($_POST["alamat_toko"]);
    $telepon_toko = clean_input($_POST["telepon_toko"]);

    $sql = "INSERT INTO info_toko (nama_toko, alamat_toko, telepon_toko) VALUES ('$nama_toko', '$alamat_toko', '$telepon_toko')";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Proses penghapusan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hapus"])) {
    $id = $_POST["id"];

    $sql = "DELETE FROM info_toko WHERE id=$id";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Query untuk mendapatkan data info toko
$query = "SELECT * FROM info_toko";
$result = mysqli_query($koneksi, $query);

// Memeriksa apakah query berhasil dieksekusi
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Toko</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data Info Toko</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nama_toko">Nama Toko:</label><br>
        <input type="text" id="nama_toko" name="nama_toko" required><br><br>
        <label for="alamat_toko">Alamat Toko:</label><br>
        <input type="text" id="alamat_toko" name="alamat_toko" required><br><br>
        <label for="telepon_toko">Telepon Toko:</label><br>
        <input type="text" id="telepon_toko" name="telepon_toko" required><br><br>
        <input type="submit" name="submit" value="Tambah">
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Toko</th>
                <th>Alamat Toko</th>
                <th>Telepon Toko</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Memeriksa apakah ada baris hasil dari query
            if (mysqli_num_rows($result) > 0) {
                // Menampilkan data dalam tabel
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nama_toko'] . "</td>";
                    echo "<td>" . $row['alamat_toko'] . "</td>";
                    echo "<td>" . $row['telepon_toko'] . "</td>";
                    echo "<td>
                            <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <input type='submit' name='hapus' value='Hapus'>
                            </form>
                            <form method='get' action='edit_toko.php'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <input type='submit' value='Edit'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                // Jika tidak ada data, tampilkan pesan kosong
                echo "<tr><td colspan='5'>Tidak ada data info toko.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <br>
    <a href="home.php">Kembali</a>
</body>
</html>
