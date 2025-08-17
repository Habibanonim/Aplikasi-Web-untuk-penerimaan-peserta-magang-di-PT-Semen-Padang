    <?php
    ob_start(); // Buffering output agar header() bisa digunakan
    session_start();
    include 'header.php';

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    include 'includes/db.php'; // Pastikan file koneksi database tersedia

    // Tambah Kriteria
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambahKriteria'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        $bobot = mysqli_real_escape_string($conn, $_POST['bobot']);
        $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);

        $query = "INSERT INTO kriteria (nama, deskripsi, bobot, jenis) VALUES ('$nama', '$deskripsi', '$bobot', '$jenis')";
        mysqli_query($conn, $query);
        header("Location: kriteria.php");
        exit();
    }

    // Hapus Kriteria
    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        mysqli_query($conn, "DELETE FROM kriteria WHERE id='$id'");
        header("Location: kriteria.php");
        exit();
    }

    // Edit Kriteria
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editKriteria'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        $bobot = mysqli_real_escape_string($conn, $_POST['bobot']);
        $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);

        $query = "UPDATE kriteria SET nama='$nama', deskripsi='$deskripsi', bobot='$bobot', jenis='$jenis' WHERE id='$id'";
        mysqli_query($conn, $query);
        header("Location: kriteria.php");
        exit();
    }

    ob_end_flush(); // Kirim semua output setelah halaman selesai diproses
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <!-- <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Peserta</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head> -->
    <body>
        <div class="container">
            <h1 class="text-center">Data Kriteria</h1>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahKriteriaModal">Tambah Kriteria</button>

            <table class="table table-bordered text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Bobot</th>
                        <th>Jenis</th>
                        <!-- <th>Tanggal Masuk</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM kriteria");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";

                        // Konversi value ke label yang sesuai
                        $nama_kriteria = [
                            "ipk" => "IPK",
                            "wawancara" => "Wawancara",
                            "skor" => "Skor"
                        ];

                        $deskripsi_kriteria = [
                            "opsi1" => "Ini adalah kriteria IPK",
                            "opsi2" => "Ini adalah kriteria Wawancara",
                            "opsi3" => "Ini adalah kriteria Skor"
                        ];

                        $bobot_kriteria = [
                            "pilih1" => "Sangat Penting (40%)",
                            "pilih2" => "Penting (35%)",
                            "pilih3" => "Biasa (25%)"
                        ];

                        $jenis_kriteria = [
                            "pil1" => "Benefit",
                            "pil2" => "Cost",
                        ];

                        echo "<td class='text-start'>" . ($nama_kriteria[$row['nama']] ?? $row['nama']) . "</td>";
                        echo "<td class='text-start'>" . ($deskripsi_kriteria[$row['deskripsi']] ?? $row['deskripsi']) . "</td>";
                        echo "<td>" . ($bobot_kriteria[$row['bobot']] ?? $row['bobot']) . "</td>";
                        echo "<td>" . ($jenis_kriteria[$row['jenis']] ?? $row['jenis']) . "</td>";

                        echo "<td>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editKriteriaModal{$row['id']}'>Edit</button>
                            <a href='kriteria.php?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                            </td>";
                        echo "</tr>";

                        // Modal Edit 
                        echo "<div class='modal fade' id='editKriteriaModal{$row['id']}' tabindex='-1'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Kriteria</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <form method='POST' action=''>
                                            <div class='modal-body'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                
                                                <label>Nama</label>
                                                <select name='nama' class='form-control' required>
                                                    <option value='ipk' " . ($row['nama'] == 'ipk' ? 'selected' : '') . ">IPK</option>
                                                    <option value='wawancara' " . ($row['nama'] == 'wawancara' ? 'selected' : '') . ">Wawancara</option>
                                                    <option value='skor' " . ($row['nama'] == 'skor' ? 'selected' : '') . ">Skor</option>
                                                </select>

                                                <label>Deskripsi</label>
                                                <select name='deskripsi' class='form-control' required>
                                                    <option value='opsi1' " . ($row['deskripsi'] == 'opsi1' ? 'selected' : '') . ">Ini adalah kriteria IPK</option>
                                                    <option value='opsi2' " . ($row['deskripsi'] == 'opsi2' ? 'selected' : '') . ">Ini adalah kriteria Wawancara</option>
                                                    <option value='opsi3' " . ($row['deskripsi'] == 'opsi3' ? 'selected' : '') . ">Ini adalah kriteria Skor</option>
                                                </select>

                                                <label>Bobot</label>
                                                <select name='bobot' class='form-control' required>
                                                    <option value='pilih1' " . ($row['bobot'] == 'pilih1' ? 'selected' : '') . ">Sangat Penting (40%)</option>
                                                    <option value='pilih2' " . ($row['bobot'] == 'pilih2' ? 'selected' : '') . ">Penting (35%)</option>
                                                    <option value='pilih3' " . ($row['bobot'] == 'pilih3' ? 'selected' : '') . ">Biasa (25%)</option>
                                                </select>

                                                <label>Jenis</label>
                                                <select name='jenis' class='form-control' required>
                                                    <option value='pil1' " . ($row['jenis'] == 'pil1' ? 'selected' : '') . ">Benefit</option>
                                                    <option value='pil2' " . ($row['jenis'] == 'pil2' ? 'selected' : '') . ">Cost</option>
                                                </select>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                <button type='submit' class='btn btn-primary' name='editKriteria'>Simpan</button>
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

        <!-- Modal Tambah Kriteria -->
        <div class="modal fade" id="tambahKriteriaModal" tabindex="-1" aria-labelledby="tambahKriteriaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKriteriaModalLabel">Tambah Kriteria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="">
                        <div class="modal-body">

                        <script>
                        function updateFields() {
                            var nama = document.getElementById("nama").value;
                            var deskripsi = document.getElementById("deskripsi");
                            var bobot = document.getElementById("bobot");
                            var jenis = document.getElementById("jenis");

                            if (nama === "ipk") {
                                deskripsi.value = "opsi1"; // Ini adalah kriteria ipk
                                bobot.value = "pilih2"; // Penting (35%)
                                jenis.value = "pil1"; 
                            } else if (nama === "wawancara") {
                                deskripsi.value = "opsi2"; // Ini adalah kriteria wawancara
                                bobot.value = "pilih1"; // Sangat Penting (40%)
                                jenis.value = "pil1"; 
                            } else if (nama === "skor") {
                                deskripsi.value = "opsi3"; // Ini adalah kriteria skor
                                bobot.value = "pilih3"; // Biasa (25%)
                                jenis.value = "pil1"; 
                            }
                        }
                        </script>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <select class="form-control" id="nama" name="nama" required onchange="updateFields()">
                                    <option value="" disabled selected>~Pilih Kriteria~</option>
                                    <option value="ipk">Ipk</option>
                                    <option value="wawancara">Wawancara</option>
                                    <option value="skor">Skor</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <select class="form-control" id="deskripsi" name="deskripsi" required>
                                    <option value="" disabled selected>~Pilih Deskripsi~</option>
                                    <option value="opsi1">Ini adalah kriteria ipk</option>
                                    <option value="opsi2">Ini adalah kriteria wawancara</option>
                                    <option value="opsi3">Ini adalah kriteria skor</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="bobot" class="form-label">Bobot</label>
                                <select class="form-control" id="bobot" name="bobot" required>
                                    <option value="" disabled selected>~Pilih bobot~</option>
                                    <option value="pilih1">Sangat Penting (40%)</option>
                                    <option value="pilih2">Penting (35%)</option>
                                    <option value="pilih3">Biasa (25%)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-control" id="jenis" name="jenis" required>
                                    <option value="" disabled selected>~Pilih~</option>
                                    <option value="pil1">Benefit</option>
                                    <option value="pil2">Cost</option>
                                </select>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="tambahKriteria">Tambah</button>
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
