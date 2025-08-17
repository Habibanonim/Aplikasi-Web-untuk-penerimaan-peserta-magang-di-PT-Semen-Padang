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

// Ambil data peserta yang lulus dan nama peserta
$query_lulus = "SELECT p.id AS peserta_id, p.nama_peserta, k.konversi_ipk, k.konversi_wawancara, k.konversi_skor
                FROM peserta_kriteria p
                JOIN konversi_peserta k ON p.id = k.peserta_id
                WHERE k.defuzzifikasi > 65";

$result_lulus = mysqli_query($conn, $query_lulus);
$lulus_peserta = [];

while ($row = mysqli_fetch_assoc($result_lulus)) {
    $lulus_peserta[] = $row;
}


// Jika ada peserta yang lulus, lakukan perhitungan ranking
if (!empty($lulus_peserta)) {
    // Hapus semua data lama di tabel perengkingan_saw agar ranking diperbarui
    mysqli_query($conn, "DELETE FROM perengkingan_saw");

    // Ambil nilai maksimal untuk normalisasi
    $max_ipk = max(array_column($lulus_peserta, 'konversi_ipk'));
    $max_wawancara = max(array_column($lulus_peserta, 'konversi_wawancara'));
    $max_skor = max(array_column($lulus_peserta, 'konversi_skor'));

    $ranking_data = [];

    // Hitung normalisasi dan skor total
    foreach ($lulus_peserta as $peserta) {
        $normalisasi_ipk = $peserta['konversi_ipk'] / $max_ipk;
        $normalisasi_wawancara = $peserta['konversi_wawancara'] / $max_wawancara;
        $normalisasi_skor = $peserta['konversi_skor'] / $max_skor;

        $skor_total = round(
            ($normalisasi_ipk * 0.35) +
            ($normalisasi_wawancara * 0.4) +
            ($normalisasi_skor * 0.25),
            4
        );

        $ranking_data[] = [
            'peserta_id' => $peserta['peserta_id'],
            'nama_peserta' => $peserta['nama_peserta'],
            'skor_total' => $skor_total
        ];
    }

    // Urutkan berdasarkan skor_total secara descending (tertinggi ke terendah)
    usort($ranking_data, function ($a, $b) {
        return $b['skor_total'] <=> $a['skor_total'];
    });

    // Masukkan data ranking ke tabel perengkingan_saw
    foreach ($ranking_data as $index => $rank) {
        $peserta_id = $rank['peserta_id'];
        $nama_peserta = $rank['nama_peserta'];
        $skor_total = $rank['skor_total'];
        $ranking = $index + 1;

        // Masukkan data ke tabel perengkingan_saw
        $insert_query = "INSERT INTO perengkingan_saw (peserta_id, nama_peserta, skor_total, ranking)
                         VALUES ('$peserta_id', '$nama_peserta', '$skor_total', '$ranking')";
        mysqli_query($conn, $insert_query);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Nilai Preferensi dan Perengkingan</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Nilai Preferensi dan Perengkingan</h1>
        <h4 class="text-center">Tabel Hasil Perengkingan</h4>
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Ranking</th>
                    <th>Nama Peserta</th>
                    <th>Skor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data dari tabel perengkingan_saw dengan urutan skor tertinggi ke terendah
                $query_ranking = "SELECT * FROM perengkingan_saw ORDER BY skor_total DESC";
                $result_ranking = mysqli_query($conn, $query_ranking);

                while ($row = mysqli_fetch_assoc($result_ranking)) {
                    echo "<tr>";
                    echo "<td>" . $row['ranking'] . "</td>";
                    echo "<td>" . $row['nama_peserta'] . "</td>";
                    echo "<td>" . $row['skor_total'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- TOMBOL NAVIGASI -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary" onclick="window.history.back()">Back</button>
            <button class="btn btn-success" onclick="window.location.href='perhitungan_saw.php'">Selesai</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
?>
