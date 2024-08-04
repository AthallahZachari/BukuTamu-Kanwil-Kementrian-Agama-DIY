<?php
$host = 'localhost';  // Nama host database
$db = 'bukutamu_db';     // Nama database
$user = 'root';       // Username database
$pass = '';           // Password database (sementara kosong tidak ada password)

try {
    // PDO = PHP Data Object
    // Membuat objek PDO untuk koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    
    // throw exceptions PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // error message
    die("Could not connect to database $db: " . $e->getMessage());
}
?>