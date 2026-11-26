<?php
// Koneksi ke database MariaDB/MySQL (XAMPP)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "web1_pertemuan09"; // sesuaikan dengan nama database di praktikum.sql

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = new mysqli($host, $user, $pass, $db);
    $koneksi->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
