<?php
include 'koneksi.php'; // Menghubungkan ke file koneksi.php

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Memeriksa apakah tombol Hapus diklik
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hapus"])) {
    $id = clean_input($_POST["id"]);

    // Query untuk menghapus admin dari database
    $sql = "DELETE FROM admin WHERE id=$id";

    // Jalankan query
    if (mysqli_query($koneksi, $sql)) {
        echo "Data admin berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Query untuk mendapatkan data admin
$query = "SELECT * FROM admin";
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
    <title>Kelola Admin</title>
</head>
<body>
    <h1>Kelola Admin</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Output data dari setiap baris
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>
                    <form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <input type='submit' name='hapus' value='Hapus'>
                    </form>
                    <a href='edit_admin.php?id=" . $row["id"] . "'>Edit</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
    <button onclick="window.location.href='home.php'">Kembali ke Dashboard</button>

</body>
</html>
