<?php
function calculateFuzzifikasiIPK($value) {
    $rendah = 0;
    $tinggi = 0;

    if ($value <= 2) {
        $rendah = 1;
    } elseif ($value > 2 && $value < 3.5) {
        $rendah = (3.5 - $value) / (3.5 - 2);
    } else {
        $rendah = 0;
    }

    if ($value <= 2) {
        $tinggi = 0;
    } elseif ($value > 2 && $value < 3.5) {
        $tinggi = ($value - 2) / (3.5 - 2);
    } else {
        $tinggi = 1;
    }

    return ["rendah" => round($rendah, 2), "tinggi" => round($tinggi, 2)];
}

// Fungsi untuk menghitung fuzzifikasi wawancara dan skor dengan rentang 1-100
function calculateFuzzifikasi($value) {
    $rendah = 0;
    $tinggi = 0;

    if ($value <= 33) {
        $rendah = 1;
    } elseif ($value > 33 && $value < 67) {
        $rendah = (67 - $value) / (67 - 33);
    } else {
        $rendah = 0;
    }

    if ($value <= 33) {
        $tinggi = 0;
    } elseif ($value > 33 && $value < 67) {
        $tinggi = ($value - 33) / (67 - 33);
    } else {
        $tinggi = 1;
    }

    return ["rendah" => round($rendah, 2), "tinggi" => round($tinggi, 2)];
}

//INFERENSI
// Aturan Fuzzy
const RULES = [
    ['ipk' => 'rendah', 'wawancara' => 'rendah', 'skor' => 'rendah', 'kelulusan' => 'tidak_lulus'],
    ['ipk' => 'rendah', 'wawancara' => 'rendah', 'skor' => 'tinggi', 'kelulusan' => 'tidak_lulus'],
    ['ipk' => 'rendah', 'wawancara' => 'tinggi', 'skor' => 'rendah', 'kelulusan' => 'tidak_lulus'],
    ['ipk' => 'rendah', 'wawancara' => 'tinggi', 'skor' => 'tinggi', 'kelulusan' => 'lulus'],
    ['ipk' => 'tinggi', 'wawancara' => 'rendah', 'skor' => 'rendah', 'kelulusan' => 'tidak_lulus'],
    ['ipk' => 'tinggi', 'wawancara' => 'rendah', 'skor' => 'tinggi', 'kelulusan' => 'lulus'],
    ['ipk' => 'tinggi', 'wawancara' => 'tinggi', 'skor' => 'rendah', 'kelulusan' => 'lulus'],
    ['ipk' => 'tinggi', 'wawancara' => 'tinggi', 'skor' => 'tinggi', 'kelulusan' => 'lulus'],
];

// Fungsi mencari nilai α-Predikat dan Z berdasarkan aturan fuzzy
function calculateAlpha($ipk_fuzz, $wawancara_fuzz, $skor_fuzz) {
    $inferences = [];
    foreach (RULES as $rule) {
        $alpha = min(
            $ipk_fuzz[$rule['ipk']],
            $wawancara_fuzz[$rule['wawancara']],
            $skor_fuzz[$rule['skor']]
        );
        
        // Menentukan nilai Z berdasarkan status kelulusan
        if ($rule['kelulusan'] == 'tidak_lulus') {
            $z = 67 - ($alpha * (67 - 33));
        } else {
            $z = 33 + ($alpha * (67 - 33));
        }
        
        $inferences[] = ['alpha' => $alpha, 'z' => round($z, 2)];
    }
    return $inferences;
}


// Fungsi Defuzzifikasi
function calculateDefuzzifikasi($inferences) {
    $sum_alpha_z = 0;
    $sum_alpha = 0;

    foreach ($inferences as $inference) {
        $sum_alpha_z += $inference['alpha'] * $inference['z'];
        $sum_alpha += $inference['alpha'];
    }

    if ($sum_alpha == 0) {
        return 0; // Hindari pembagian dengan nol
    }

    return round($sum_alpha_z / $sum_alpha, 2);
}

// Ambil data dari database
$result = mysqli_query($conn, "SELECT * FROM peserta_kriteria");
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
?>