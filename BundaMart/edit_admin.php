<?php
include 'koneksi.php'; // Menghubungkan ke file koneksi.php

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Memeriksa apakah parameter ID ada dalam URL
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Mendapatkan nilai parameter dari URL
    $id = clean_input($_GET["id"]);

    // Persiapkan statement SELECT
    $sql = "SELECT * FROM admin WHERE id = ?";

    if($stmt = mysqli_prepare($koneksi, $sql)){
        // Bind variabel ke pernyataan persiapan sebagai parameter
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameter
        $param_id = $id;

        // Mencoba mengeksekusi pernyataan persiapan
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                /* Mengambil baris hasil sebagai array asosiatif.
                Baris hasil memiliki format: id, nama, email */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Mendapatkan nilai bidang individu
                $nama = $row["username"];
                $email = $row["email"];
            } else{
                // URL tidak berisi ID yang valid. Redirect ke halaman error
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Terjadi kesalahan. Silakan coba lagi nanti.";
        }
    }

    // Menutup pernyataan
    mysqli_stmt_close($stmt);

    // Menutup koneksi
    mysqli_close($koneksi);
} else{
    // URL tidak berisi parameter ID. Redirect ke halaman error
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
</head>
<body>
    <h1>Edit Admin</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div>
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo $nama; ?>">
        </div>
        <div>
            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
        </div>
        <div>
            <input type="submit" value="Simpan">
            <a href="akun.php">Batal</a>
        </div>
    </form>
</body>
</html>
