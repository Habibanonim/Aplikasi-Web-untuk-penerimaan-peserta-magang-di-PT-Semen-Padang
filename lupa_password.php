<?php
// Sertakan file koneksi database
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Cek apakah username ada di database
    $checkUserQuery = "SELECT * FROM users WHERE username='$username'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) == 0) {
        $error = "Username tidak ditemukan!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Password tidak cocok!";
    } else {
        // Enkripsi password baru dan update di database
        $hashed_password = md5($new_password);
        $updateQuery = "UPDATE users SET password='$hashed_password' WHERE username='$username'";
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Terjadi kesalahan, coba lagi nanti!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="assets/img/logo/profile.png" alt="logo">
                <h2>SEMEN PADANG</h2>
                <p>- Kabau Sirah -</p>
            </div>
            <h2>Reset Password</h2>
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="">
                <div class="input-box">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="input-box">
                    <label>Password Baru</label>
                    <input type="password" name="new_password" placeholder="Masukkan Password Baru" required>
                </div>
                <div class="input-box">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required>
                </div>
                <button type="submit">Reset Password</button>
                <p><a href="login.php">Kembali ke Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
