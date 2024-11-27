<?php
$host = 'localhost';
$dbname = 'ong_management';
$username = 'root';
$password = 'Bobo2003';

try {
    // $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn = new PDO("mysql://f2w6a48j1tdjr087:zv2sfr1ata791nk1@ivgz2rnl5rh7sphb.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306/sdwylz8sv76m9qdg");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Conexiunea la baza de date a eșuat: " . $e->getMessage());
}
?>
