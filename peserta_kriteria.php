<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php'; // Pastikan file koneksi database tersedia

// Tambah Peserta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambahPesertaKriteria'])) {
    $nama_peserta = mysqli_real_escape_string($conn, $_POST['nama_peserta']);
    $ipk = mysqli_real_escape_string($conn, $_POST['ipk']);
    $wawancara = mysqli_real_escape_string($conn, $_POST['wawancara']);
    $skor = mysqli_real_escape_string($conn, $_POST['skor']);

    $query = "INSERT INTO peserta_kriteria (nama_peserta, ipk, wawancara, skor) VALUES ('$nama_peserta', '$ipk', '$wawancara', '$skor')";
    mysqli_query($conn, $query);
    header("Location: peserta_kriteria.php");
    exit();
}

// Hapus Peserta
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM normalisasi_saw");
    mysqli_query($conn, "DELETE FROM perengkingan_saw");
    mysqli_query($conn, "DELETE FROM peserta_kriteria WHERE id='$id'");
    header("Location: peserta_kriteria.php");
    exit();
}

// Edit Peserta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editPesertaKriteria'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nama_peserta = mysqli_real_escape_string($conn, $_POST['nama_peserta']);
    $ipk = mysqli_real_escape_string($conn, $_POST['ipk']);
    $wawancara = mysqli_real_escape_string($conn, $_POST['wawancara']);
    $skor = mysqli_real_escape_string($conn, $_POST['skor']);

    $query = "UPDATE peserta_kriteria SET nama_peserta='$nama_peserta', ipk='$ipk', wawancara='$wawancara', skor='$skor' WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: peserta_kriteria.php");
    exit();
}

include 'header.php';

?>



<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container">
        <h1 class="text-center">Daftar Penilaian Peserta </h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahPesertaKriteriaModal">Tambah Penilaian</button>

        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <!-- <th>No</th> -->
                    <th>Nama Peserta</th>
                    <th>Ipk</th>
                    <th>Wawancara</th>
                    <th>Skor</th>
                    <th>Action</th>
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
                    echo "<td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editPesertaKriteriaModal{$row['id']}'>Edit</button>
                        <a href='peserta_kriteria.php?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                        </td>";
                    echo "</tr>";

                    // Modal Edit 
                    echo "<div class='modal fade' id='editPesertaKriteriaModal{$row['id']}' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Edit Peserta Kriteria</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <form method='POST' action=''>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <label>Nama Peserta</label>
                                            <input type='text' name='nama_peserta' class='form-control' value='{$row['nama_peserta']}' required>
                                            <label>Ipk</label>
                                            <input type='text' name='ipk' class='form-control' value='{$row['ipk']}' required>
                                            <label>Wawancara</label>
                                            <input type='text' name='wawancara' class='form-control' value='{$row['wawancara']}' required>
                                            <label>Skor</label>
                                            <input type='text' name='skor' class='form-control' value='{$row['skor']}' required>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-primary' name='editPesertaKriteria'>Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
                }     
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Peserta -->
    <div class="modal fade" id="tambahPesertaKriteriaModal" tabindex="-1" aria-labelledby="tambahPesertaKriteriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPesertaKriteriaModalLabel">Tambah Penilaian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_peserta" class="form-label">Nama Peserta</label>
                            <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" required>
                        </div>
                        <div class="mb-3">
                            <label for="ipk" class="form-label">Ipk</label>
                            <input type="text" class="form-control" id="ipk" name="ipk" required>
                        </div>
                        <div class="mb-3">
                            <label for="wawancara" class="form-label">Wawancara</label>
                            <input type="text" class="form-control" id="wawancara" name="wawancara" required>
                        </div>
                        <div class="mb-3">
                            <label for="skor" class="form-label">Skor</label>
                            <input type="text" class="form-control" id="skor" name="skor" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="tambahPesertaKriteria">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<?php
include 'footer.php';
?>
