<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';
include 'header.php';

// Ambil data peserta yang lulus
$query_lulus = "SELECT p.id AS peserta_id, p.nama_peserta, k.konversi_ipk, k.konversi_wawancara, k.konversi_skor, k.defuzzifikasi
                FROM peserta_kriteria p
                JOIN konversi_peserta k ON p.id = k.peserta_id
                WHERE k.defuzzifikasi > 65";

$result_lulus = mysqli_query($conn, $query_lulus);
$lulus_peserta = [];

while ($row = mysqli_fetch_assoc($result_lulus)) {
    $lulus_peserta[] = $row;
}


// Cek apakah ada peserta yang lulus
if (!empty($lulus_peserta)) {
    // Ambil nilai maksimal untuk normalisasi
    $max_ipk = max(array_column($lulus_peserta, 'konversi_ipk'));
    $max_wawancara = max(array_column($lulus_peserta, 'konversi_wawancara'));
    $max_skor = max(array_column($lulus_peserta, 'konversi_skor'));

    // Hitung normalisasi dan simpan ke database
    foreach ($lulus_peserta as &$peserta) {
        $peserta['normalisasi_ipk'] = $peserta['konversi_ipk'] / $max_ipk;
        $peserta['normalisasi_wawancara'] = $peserta['konversi_wawancara'] / $max_wawancara;
        $peserta['normalisasi_skor'] = $peserta['konversi_skor'] / $max_skor;

        $peserta_id = $peserta['peserta_id'];
        $normalisasi_ipk = $peserta['normalisasi_ipk'];
        $normalisasi_wawancara = $peserta['normalisasi_wawancara'];
        $normalisasi_skor = $peserta['normalisasi_skor'];
        $defuzzifikasi = $peserta['defuzzifikasi'];

        // Cek apakah peserta sudah ada di tabel normalisasi_saw
        $cek_query = "SELECT COUNT(*) AS total FROM normalisasi_saw WHERE peserta_id = '$peserta_id'";
        $cek_result = mysqli_query($conn, $cek_query);
        $cek_data = mysqli_fetch_assoc($cek_result);

        if ($cek_data['total'] == 0) {
            // Jika belum ada, masukkan data baru
            $insert_query = "INSERT INTO normalisasi_saw (peserta_id, normalisasi_ipk, normalisasi_wawancara, normalisasi_skor, defuzzifikasi)
                             VALUES ('$peserta_id', '$normalisasi_ipk', '$normalisasi_wawancara', '$normalisasi_skor', '$defuzzifikasi')";
            mysqli_query($conn, $insert_query);
        }
    }
    unset($peserta); // Hapus referensi terakhir
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Normalisasi Nilai - Peserta Lulus</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Normalisasi Nilai</h1>
        <h4 class="text-center">Tabel Normalisasi Nilai Peserta yang Lulus</h4>
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <!-- <th>Nama Peserta</th> -->
                    <th class="text-center">Normalisasi IPK</th>
                    <th class="text-center">Normalisasi Wawancara</th>
                    <th class="text-center">Normalisasi Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lulus_peserta as $peserta): ?>
                    <tr>

                        <td><?= round($peserta['normalisasi_ipk'], 4); ?></td>
                        <td><?= round($peserta['normalisasi_wawancara'], 4); ?></td>
                        <td><?= round($peserta['normalisasi_skor'], 4); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- TOMBOL NAVIGASI -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary" onclick="window.history.back()">Back</button>
            <button class="btn btn-primary" onclick="window.location.href='perengkingan_saw.php'">Lanjut ke Perhitungan SAW</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
?>
