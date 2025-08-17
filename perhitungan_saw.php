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
include 'function_fuzzy.php';

// Ambil data peserta yang lulus dari hasil defuzzifikasi
$result = mysqli_query($conn, "SELECT * FROM peserta_kriteria");
$lulus_peserta = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Proses Fuzzifikasi
    $ipk_fuzz = calculateFuzzifikasiIPK($row['ipk']);
    $wawancara_fuzz = calculateFuzzifikasi($row['wawancara']);
    $skor_fuzz = calculateFuzzifikasi($row['skor']);

    // Proses Inferensi
    $inferences = calculateAlpha($ipk_fuzz, $wawancara_fuzz, $skor_fuzz);

    // Proses Defuzzifikasi
    $z_star = calculateDefuzzifikasi($inferences);

    // Tentukan Kelulusan
    if ($z_star > 65) {
        $row['defuzzifikasi'] = $z_star;
        $lulus_peserta[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Hasil SAW - Peserta Lulus</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Perhitungan SAW</h1>
        <h4 class="text-center">Tabel Peserta Yang Lulus dan Nilai Kriteria</h4>
        
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">Nama Peserta</th>
                    <th class="text-center">IPK</th>
                    <th class="text-center">Wawancara</th>
                    <th class="text-center">Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lulus_peserta as $peserta): ?>
                    <tr>
                        <td class="text-start"><?= htmlspecialchars($peserta['nama_peserta']); ?></td>
                        <td><?= $peserta['ipk']; ?></td>
                        <td><?= $peserta['wawancara']; ?></td>
                        <td><?= $peserta['skor']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- TOMBOL KEMBALI -->
        <div class="text-center mt-4">
            <button class="btn btn-primary mb-3" onclick="window.location.href='konversi_saw.php'">Lanjut ke Konversi Nilai</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
?>
