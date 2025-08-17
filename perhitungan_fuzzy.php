<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php'; 
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container">
        <h1 class="text-center">Daftar Nilai Kriteria Peserta </h1>
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <!-- <th>No</th> -->
                    <th>Nama Karyawan</th>
                    <th>Ipk</th>
                    <th>Wawancara</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM peserta_kriteria");
                // $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    // echo "<td>" . $no++ . "</td>";
                    echo "<td class='text-start'>" . $row['nama_peserta'] . "</td>";
                    echo "<td>" . $row['ipk'] . "</td>";
                    echo "<td>" . $row['wawancara'] . "</td>";
                    echo "<td>" . $row['skor'] . "</td>";
                    echo "</tr>";
                }     
                ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <button class="btn btn-primary mb-3" onclick="window.location.href='masuk_perhitungan_fuzzy.php'">Mulai Perhitungan Fuzzy Tsukamoto</button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
?>
