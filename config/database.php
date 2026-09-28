<?php
$host = 'localhost';
$port = '3307'; // Tukar mengikut port XAMPP anda jika perlu (biasanya 3306 atau 3307)
$db   = 'miniproject2_db';
$user = 'root';
$pass = ''; // Biarkan kosong jika tiada password

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Sambungan pangkalan data gagal: " . $e->getMessage());
}
?>