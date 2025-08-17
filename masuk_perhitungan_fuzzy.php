<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php'; 
include 'header.php';

include 'function_fuzzy.php';

// Ambil data dari database
$result = mysqli_query($conn, "SELECT * FROM peserta_kriteria");
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Hasil Fuzzifikasi</title>
</head>
<body>
    <!-- FUZZIFIKASI -->
    <div class="container mt-5">
        <h1 class="text-center">Hasil Fuzzifikasi untuk Semua Peserta</h1>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM peserta_kriteria");
        while ($row = mysqli_fetch_assoc($result)) {
            $ipk_fuzzifikasi = calculateFuzzifikasiIPK($row['ipk']);
            $wawancara_fuzzifikasi = calculateFuzzifikasi($row['wawancara']);
            $skor_fuzzifikasi = calculateFuzzifikasi($row['skor']);
        ?>

        <div class="card mb-4">
            <div class="card-header text-white bg-primary">
                <h5 class="mb-0"><?php echo $row['nama_peserta']; ?></h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">Kriteria</h6>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th>Rendah</th>
                            <th>Tinggi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>IPK</td>
                            <td><?php echo $ipk_fuzzifikasi['rendah']; ?></td>
                            <td><?php echo $ipk_fuzzifikasi['tinggi']; ?></td>
                        </tr>
                        <tr>
                            <td>Wawancara</td>
                            <td><?php echo $wawancara_fuzzifikasi['rendah']; ?></td>
                            <td><?php echo $wawancara_fuzzifikasi['tinggi']; ?></td>
                        </tr>
                        <tr>
                            <td>Skor</td>
                            <td><?php echo $skor_fuzzifikasi['rendah']; ?></td>
                            <td><?php echo $skor_fuzzifikasi['tinggi']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php } ?>
    </div>

<!-- INFERENSI -->
    <div class="container mt-5">
    <h1 class="text-center">Hasil Inferensi</h1>
    <?php foreach ($data as $peserta): ?>
        <?php
        $ipk_fuzz = calculateFuzzifikasiIPK($peserta['ipk']);
        $wawancara_fuzz = calculateFuzzifikasi($peserta['wawancara']);
        $skor_fuzz = calculateFuzzifikasi($peserta['skor']);
        $inferences = calculateAlpha($ipk_fuzz, $wawancara_fuzz, $skor_fuzz);
        ?>
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <?= htmlspecialchars($peserta['nama_peserta']); ?>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Rule</th>
                        <th>α-Predikat</th>
                        <th>Z</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($inferences as $index => $inference): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td class="text-start" ><?= 'Ipk: '.RULES[$index]['ipk']. ' AND ' .'Wawancara: '. RULES[$index]['wawancara'] . ' AND ' . 'Skor: '. RULES[$index]['skor']. ' Then '. 'Kelulusan: '.RULES[$index]['kelulusan']; ?></td>
                            <td><?= number_format($inference['alpha'], 4); ?></td>
                            <td><?= $inference['z']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- DEFUZZIFIKASI -->
    <div class="container mt-5">
    <h1 class="text-center">Hasil Defuzzifikasi</h1>
    <div class="card mb-3">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Hasil Defuzzifikasi</th>
                        <th>Kelulusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $peserta): ?>
                        <?php
                        // Proses Fuzzifikasi
                        $ipk_fuzz = calculateFuzzifikasiIPK($peserta['ipk']);
                        $wawancara_fuzz = calculateFuzzifikasi($peserta['wawancara']);
                        $skor_fuzz = calculateFuzzifikasi($peserta['skor']);

                        // Proses Inferensi
                        $inferences = calculateAlpha($ipk_fuzz, $wawancara_fuzz, $skor_fuzz);

                        // Proses Defuzzifikasi
                        $z_star = calculateDefuzzifikasi($inferences);

                        // Tentukan Kelulusan
                        $kelulusan = $z_star <= 65 ? 'Tidak Lulus' : 'Lulus';
                        $kelulusan_class = $z_star <= 65 ? 'text-danger' : 'text-success';

                        // Simpan ke database
                        $peserta_id = $peserta['id'];
                        $nama_peserta = mysqli_real_escape_string($conn, $peserta['nama_peserta']);
                        $hasil_defuzzifikasi = $z_star;

                        // Cek apakah sudah ada data peserta ini
                        $check_query = "SELECT * FROM hasil_defuzzifikasi WHERE peserta_id = '$peserta_id'";
                        $check_result = mysqli_query($conn, $check_query);

                        if (mysqli_num_rows($check_result) > 0) {
                            // Update data jika sudah ada
                            $query = "UPDATE hasil_defuzzifikasi SET hasil_defuzzifikasi = '$hasil_defuzzifikasi', kelulusan = '$kelulusan' WHERE peserta_id = '$peserta_id'";
                        } else {
                            // Insert data jika belum ada
                            $query = "INSERT INTO hasil_defuzzifikasi (peserta_id, nama_peserta, hasil_defuzzifikasi, kelulusan)
                                      VALUES ('$peserta_id', '$nama_peserta', '$hasil_defuzzifikasi', '$kelulusan')";
                        }
                        mysqli_query($conn, $query);
                        ?>
                        <tr>
                            <td class="text-start"><?= htmlspecialchars($peserta['nama_peserta']); ?></td>
                            <td><?= $z_star; ?></td>
                            <td class="<?= $kelulusan_class; ?>"><?= $kelulusan; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- TOMBOL KEMBALI -->
    <div class="text-center mt-4">
        <button class="btn btn-primary" onclick="window.history.back()">Kembali</button>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
?>
