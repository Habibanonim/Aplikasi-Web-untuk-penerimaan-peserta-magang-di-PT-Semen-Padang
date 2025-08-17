<?php
// Sertakan file koneksi database
include 'includes/db.php';

session_start(); // Mulai sesi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Cek apakah username ada di database
    $checkUserQuery = "SELECT * FROM users WHERE username='$username'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) == 0) {
        // Jika username tidak ditemukan, tampilkan pesan error
        $error = "Anda belum memiliki akun, cobalah untuk mendaftar!";
    } else {
        // Ambil data pengguna
        $user = mysqli_fetch_assoc($checkUserResult);
        
        // Cek apakah posisi yang dimasukkan sesuai dengan yang terdaftar di database
        if ($user['role'] !== $role) {
            $error = "Position salah!";
        } else {
            // Cek apakah password cocok
            if ($user['password'] === md5($password)) {
                // Simpan informasi user ke sesi
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Simpan role dari database
                
                // Redirect berdasarkan role
                if ($user['role'] === 'Kepala') {
                    header("Location: kepala/dashboard_kepala.php"); // Jika Kepala, masuk ke dashboard Kepala
                } else {
                    header("Location: index.php"); // Jika Admin, masuk ke dashboard Admin
                }
                exit();
            } else {
                $error = "Username atau password salah!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <!-- Logo -->
            <div class="logo">
                <img src="assets/img/logo/profile.png" alt="logo">
                <h2>SEMEN PADANG</h2>
                <p>- Kabau Sirah -</p>
            </div>

            <?php if (isset($error)) { ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php } ?>

            <!-- Formulir Login -->
            <form method="POST" action="">
                <h3>Welcome!</h3>
                <div class="input-box">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="input-box">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                </div>
                <div class="input-box">
                    <label>Position</label>
                    <select name="role" required>
                        <option value="">-- Pilih Bagian --</option>
                        <option value="Kepala">Kepala</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Sign in</button>
                <p style="text-align: center; margin-top: 10px;">
                    <a href="lupa_password.php">Lupa Password?</a>
                </p>

            </form>

            <!-- Tautan ke Daftar -->
            <p style="text-align: center; margin-top: 10px;">Don't have an account? <a href="register.php">Create an account</a></p>
        </div>
    </div>
</body>
</html>
