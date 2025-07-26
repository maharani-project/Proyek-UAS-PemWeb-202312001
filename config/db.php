<?php
$host = 'localhost';
$user = 'root';
$pass = 'denpasar';
$db   = 'mbetaro';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
