<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';
include '../kepala/header_kepala.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Hasil Final</title>
    <style>
        .lulus {
            color: green;
            font-weight: bold;
        }

        .tidak-lulus {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Hasil Final</h1>
        <h4 class="text-center">Tabel Hasil Perhitungan</h4>
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Ranking</th>
                    <th>Nama</th>
                    <th>Kelulusan</th>
                    <th>Skor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data peserta yang lulus terlebih dahulu
                $query_lulus = "SELECT p.ranking, h.nama_peserta, h.kelulusan, p.skor_total 
                                FROM perengkingan_saw p
                                JOIN hasil_defuzzifikasi h ON p.peserta_id = h.peserta_id
                                WHERE h.kelulusan = 'Lulus'
                                ORDER BY p.ranking ASC";
                
                $result_lulus = mysqli_query($conn, $query_lulus);
                $last_rank = 0;

                while ($row = mysqli_fetch_assoc($result_lulus)) {
                    $last_rank = $row['ranking']; // Menyimpan ranking terakhir dari peserta yang lulus
                    $skor_total = round($row['skor_total'], 2); // Pembulatan 2 angka di belakang koma
                    echo "<tr>";
                    echo "<td>" . $row['ranking'] . "</td>";
                    echo "<td>" . $row['nama_peserta'] . "</td>";
                    echo "<td class='lulus'>" . $row['kelulusan'] . "</td>";
                    echo "<td>" . number_format($skor_total, 2) . "</td>";
                    echo "</tr>";
                }

                // Ambil data peserta yang tidak lulus
                $query_tidak_lulus = "SELECT h.nama_peserta, h.kelulusan 
                                      FROM hasil_defuzzifikasi h
                                      WHERE h.kelulusan = 'Tidak Lulus'
                                      ORDER BY h.nama_peserta ASC";

                $result_tidak_lulus = mysqli_query($conn, $query_tidak_lulus);

                while ($row = mysqli_fetch_assoc($result_tidak_lulus)) {
                    $last_rank++; // Ranking lanjutan setelah peserta terakhir yang lulus
                    echo "<tr>";
                    echo "<td>" . $last_rank . "</td>";
                    echo "<td>" . $row['nama_peserta'] . "</td>";
                    echo "<td class='tidak-lulus'>" . $row['kelulusan'] . "</td>";
                    echo "<td>0.00</td>"; // Skor untuk peserta tidak lulus dibuat 0.00
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- TOMBOL NAVIGASI DAN CETAK -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary" onclick="window.history.back()">Back</button>
            <button class="btn btn-success" onclick="window.print()">Cetak</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include '../kepala/footer_kepala.php';
?>
