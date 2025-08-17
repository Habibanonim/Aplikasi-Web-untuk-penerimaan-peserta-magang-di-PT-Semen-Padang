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

function konversiIPK($ipk) {
    if ($ipk >= 3.50 && $ipk <= 4) return 1;
    if ($ipk >= 3 && $ipk <= 3.49) return 0.75;
    if ($ipk >= 2 && $ipk <= 2.99) return 0.5;
    if ($ipk >= 1 && $ipk <= 1.99) return 0.25;
    return 0;
}

function konversiNilai($nilai) {
    if ($nilai >= 90 && $nilai <= 100) return 1;
    if ($nilai >= 70 && $nilai <= 89) return 0.75;
    if ($nilai >= 50 && $nilai <= 69) return 0.5;
    if ($nilai >= 30 && $nilai <= 49) return 0.25;
    return 0;
}

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
        $row['konversi_ipk'] = konversiIPK($row['ipk']);
        $row['konversi_wawancara'] = konversiNilai($row['wawancara']);
        $row['konversi_skor'] = konversiNilai($row['skor']);
        
        // Simpan ke database
        $peserta_id = $row['id'];
        $ipk = $row['ipk'];
        $konversi_ipk = $row['konversi_ipk'];
        $wawancara = $row['wawancara'];
        $konversi_wawancara = $row['konversi_wawancara'];
        $skor = $row['skor'];
        $konversi_skor = $row['konversi_skor'];
        $defuzzifikasi = $row['defuzzifikasi'];

        $query = "INSERT INTO konversi_peserta (peserta_id, ipk, konversi_ipk, wawancara, konversi_wawancara, skor, konversi_skor, defuzzifikasi)
          VALUES ('$peserta_id', '$ipk', '$konversi_ipk', '$wawancara', '$konversi_wawancara', '$skor', '$konversi_skor', '$defuzzifikasi')
          ON DUPLICATE KEY UPDATE 
          ipk = VALUES(ipk), 
          konversi_ipk = VALUES(konversi_ipk), 
          wawancara = VALUES(wawancara), 
          konversi_wawancara = VALUES(konversi_wawancara), 
          skor = VALUES(skor), 
          konversi_skor = VALUES(konversi_skor), 
          defuzzifikasi = VALUES(defuzzifikasi)";

        mysqli_query($conn, $query);

        // Masukkan ke array peserta yang lulus
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
    <title>Konversi Nilai - Peserta Lulus</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Konversi Nilai</h1>
        <h4 class="text-center">Tabel Peserta Yang Lulus dan Konversi Nilai Kriteria</h4>
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">IPK</th>
                    <th class="text-center">Konversi IPK</th>
                    <th class="text-center">Wawancara</th>
                    <th class="text-center">Konversi Wawancara</th>
                    <th class="text-center">Skor</th>
                    <th class="text-center">Konversi Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lulus_peserta as $peserta): ?>
                    <tr>
                        <td><?= $peserta['ipk']; ?></td>
                        <td><?= $peserta['konversi_ipk']; ?></td>
                        <td><?= $peserta['wawancara']; ?></td>
                        <td><?= $peserta['konversi_wawancara']; ?></td>
                        <td><?= $peserta['skor']; ?></td>
                        <td><?= $peserta['konversi_skor']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- TOMBOL KEMBALI -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary" onclick="window.history.back()">Back</button>
            <button class="btn btn-primary" onclick="window.location.href='normalisasi_saw.php'">Lanjut ke Normalisasi Nilai</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
?>
