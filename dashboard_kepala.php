<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../koneksi/koneksi.php');
include '../kepala/header_kepala.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<main>
    <div class="container-fluid px-4">
        <div class="welcome-box shadow-lg p-4 rounded-4 text-center">
            <h1 class="mt-3 fw-bold text-primary">
                <i class="fas fa-smile-beam"></i> Hai, Selamat Datang <?php echo $_SESSION['username']; ?>!
            </h1>
            <p class="breadcrumb mb-4 text-secondary">
                Senang melihatmu kembali, semoga harimu menyenangkan! ☀️
            </p>
        </div>
    </div>
</main>

<style>
    .welcome-box {
        background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
        border-left: 5px solid #007bff;
        transition: transform 0.3s ease-in-out;
    }
    .welcome-box:hover {
        transform: scale(1.02);
    }
</style>

            
<?php
include '../kepala/footer_kepala.php';
?>