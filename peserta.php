<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php'; // Pastikan file koneksi database tersedia

// Tambah Peserta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambahPeserta'])) {
    $nama_peserta = mysqli_real_escape_string($conn, $_POST['nama_peserta']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $universitas = mysqli_real_escape_string($conn, $_POST['universitas']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);

    $query = "INSERT INTO peserta_kriteria (nama_peserta, jurusan, universitas, no_hp) VALUES ('$nama_peserta', '$jurusan', '$universitas', '$no_hp')";
    mysqli_query($conn, $query);
    header("Location: peserta.php");
    exit();
}

// Hapus Peserta
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM peserta_kriteria WHERE id='$id'");
    header("Location: peserta.php");
    exit();
}

// Edit Peserta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editPeserta'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nama_peserta = mysqli_real_escape_string($conn, $_POST['nama_peserta']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $universitas = mysqli_real_escape_string($conn, $_POST['universitas']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);

    
    $query = "UPDATE peserta_kriteria SET nama_peserta='$nama_peserta', jurusan='$jurusan', universitas='$universitas', no_hp='$no_hp' WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: peserta.php");
    exit();
}

include 'header.php';

?>



<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container">
        <h1 class="text-center">Data Peserta</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahPesertaModal">Tambah Peserta</button>

        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Universitas</th>
                    <th>No HP</th>
                    <!-- <th>Tanggal Masuk</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM peserta_kriteria");
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td class='text-start'>" . $row['nama_peserta'] . "</td>";
                    echo "<td class='text-start'>" . $row['jurusan'] . "</td>";
                    echo "<td class='text-start'>" . $row['universitas'] . "</td>";
                    echo "<td>" . $row['no_hp'] . "</td>";
                    echo "<td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editPesertaModal{$row['id']}'>Edit</button>
                        <a href='peserta.php?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                        </td>";
                    echo "</tr>";

                    // Modal Edit 
                    echo "<div class='modal fade' id='editPesertaModal{$row['id']}' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Edit Peserta</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <form method='POST' action=''>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <label>Nama</label>
                                            <input type='text' name='nama_peserta' class='form-control' value='{$row['nama_peserta']}' required>
                                            <label>Jurusan</label>
                                            <input type='text' name='jurusan' class='form-control' value='{$row['jurusan']}' required>
                                            <label>Universitas</label>
                                            <input type='text' name='universitas' class='form-control' value='{$row['universitas']}' required>
                                            <label>No HP</label>
                                            <input type='text' name='no_hp' class='form-control' value='{$row['no_hp']}' required>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-primary' name='editPeserta'>Simpan</button>
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
    <div class="modal fade" id="tambahPesertaModal" tabindex="-1" aria-labelledby="tambahPesertaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPesertaModalLabel">Tambah Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_peserta" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" required>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                        </div>
                        <div class="mb-3">
                            <label for="universitas" class="form-label">Universitas</label>
                            <input type="text" class="form-control" id="universitas" name="universitas" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="tambahPeserta">Tambah</button>
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
