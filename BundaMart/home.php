<?php
session_start();

// Periksa apakah tombol logout diklik
if (isset($_POST['logout'])) {
    // Hapus semua data sesi
    session_unset();
    // Hancurkan sesi
    session_destroy();
    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Periksa apakah admin sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data admin dari sesi
$admin_id = $_SESSION['admin_id'];

// Di sini Anda dapat menambahkan logika atau kode PHP lainnya yang diperlukan untuk dashboard Anda

// Contoh pesan selamat datang
$welcome_message = "Selamat datang di Dashboard Toko Kelontongan!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Toko Kelontongan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 20px;
            margin-bottom: 20px;
        }
        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }
        .menu-item:hover {
            background-color: #f9f9f9;
        }
        .menu-item img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }
        .logout-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="welcome"><?php echo $welcome_message; ?></h2>

        <div class="menu">
            <a href="kasir.php" class="menu-item">
                <img src="uploads/kasir1.png" alt="Kasir">
                Kasir
            </a>
            <a href="riwayat_transaksi.php" class="menu-item">
                <img src="uploads/tanagn.png" alt="Riwayat Transaksi">
                Riwayat Transaksi
            </a>
            <a href="laporan.php" class="menu-item">
                <img src="uploads/laporan.png" alt="Laporan">
                Laporan
            </a>
            <a href="kelola_produk.php" class="menu-item">
                <img src="uploads/kelola_produk.png" alt="Kelola Produk">
                Kelola Produk
            </a>
            <a href="kelola_toko.php" class="menu-item">
                <img src="uploads/12.png" alt="Kelola Toko">
                Kelola Toko
            </a>
            <a href="akun.php" class="menu-item">
                <img src="uploads/akun.png" alt="Akun">
                Akun
            </a>
        </div>
        <form method="post" style="text-align: center;">
            <button type="submit" class="logout-btn" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
