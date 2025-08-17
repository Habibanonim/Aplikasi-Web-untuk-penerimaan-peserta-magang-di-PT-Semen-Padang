<?php
include 'includes/db.php';
var_dump(mysqli_error($conn));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Cek apakah username atau email sudah ada di database
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] == $username) {
            $error = "Username sudah ada, silahkan ganti username";
        } elseif ($row['email'] == $email) {
            $error = "Email sudah terdaftar, silahkan sign in";
        }
    } elseif ($password !== $confirm_password) {
        $error = "Password tidak cocok!";
    } else {
        $hashed_password = md5($password);
        $query = "INSERT INTO users (username, email, role, password) VALUES ('$username', '$email', '$role', '$hashed_password')";

        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Terjadi kesalahan, coba lagi!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

            <?php if (isset($error)) { ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php } ?>

            <!-- Register Form -->
            <form method="POST" action="">
                <h3>Buat Akun Baru</h3>
                <div class="input-box">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <div class="input-box">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-box">
                    <label>Position</label>
                    <select name="role" required>
                        <option value="" disabled selected>~Pilih Position~</option>
                        <option value="Kepala">Kepala</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="input-box">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="input-box">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <div class="input-box">
                    <input type="checkbox" name="terms" required>
                    <label>I agree to the <a href="#">Privacy Policy & Terms</a></label>
                </div>
                <button type="submit">SIGN UP</button>
            </form>

            <!-- Link ke Login -->
            <p style="text-align: center; margin-top: 10px;">Already have an account? <a href="login.php">Sign in instead</a></p>
        </div>
    </div>
</body>
</html>
