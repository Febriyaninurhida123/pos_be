<?php
$host = "localhost"; // Nama host database (biasanya localhost)
$username = "root";   // Nama pengguna database
$password = "";       // Kata sandi database (kosongkan jika tidak ada kata sandi)
$database = "pos_be"; // Nama database

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
