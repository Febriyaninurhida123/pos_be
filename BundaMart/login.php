<?php
session_start();

// Hubungkan ke database
$host = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "pos_be"; // Ganti dengan nama database Anda

$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Periksa apakah form login telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa kecocokan data login dengan database
    $sql = "SELECT id FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $koneksi->query($sql);

    // Periksa hasil query
    if ($result->num_rows == 1) {
        // Login berhasil, tetapkan sesi
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];

        // Redirect ke halaman dashboard
        header("Location: home.php");
        exit();
    } else {
        // Login gagal
        $login_error = "Login gagal. Username atau password salah.";
    }
}

// Tutup koneksi ke database
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background_image.jpg'); /* Ganti dengan nama file latar belakang yang Anda inginkan */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 300px;
            width: 100%;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .login-container form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container form button:hover {
            background-color: #0056b3;
        }

        .register-link {
            margin-top: 20px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="uploads/regis.png" alt="Logo" style="width: 100px; margin-bottom: 20px;">
        <h2>Login</h2>
        <?php if (isset($login_error)) echo "<p>$login_error</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </div>
    </div>
</body>
</html>
