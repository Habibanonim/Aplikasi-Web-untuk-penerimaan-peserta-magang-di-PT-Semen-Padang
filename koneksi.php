<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $user = 'root';
    $pass = '';

    $koneksi = new PDO("mysql:host=localhost;dbname=login_system2", $user, $pass);

    global $url;
    $url = "http://localhostskripsi_zikri/login-system2/";

    $sql_peserta = "SELECT * FROM peserta WHERE id = 1";
    $row_peserta = $koneksi->prepare($sql_peserta);
    $row_peserta->execute();
    global $info_peserta;
    $info_peserta = $row_peserta->fetch(PDO::FETCH_OBJ);

    error_reporting(0);

    try {
        $koneksi = new PDO("mysql:host=localhost;dbname=login_system2", "root", "");
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Koneksi Gagal: " . $e->getMessage();
    }
?>