<?php
// Configurare pentru conexiunea MySQL
$host = "ivgz2rnl5rh7spbh.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; // Hostul furnizat de JawsDB
$port = "3306"; // Portul MySQL standard
$dbname = "sdwylz8sv76m9gdq"; // Numele bazei de date
$username = "f2w6a48j1tdjr087"; // Utilizatorul furnizat de JawsDB
$password = "zv2sfr1ata791nk1"; // Parola furnizată de JawsDB

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    echo "Conexiunea la baza de date a fost realizată cu succes!";
} catch (PDOException $e) {
    die("Conexiunea la baza de date a eșuat: " . $e->getMessage());
}

?>
