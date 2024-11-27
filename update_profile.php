<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email invalid!";
        exit;
    }

    try {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users SET email = :email, password = :password WHERE id = :id");
            $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'id' => $_SESSION['user_id']]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET email = :email WHERE id = :id");
            $stmt->execute(['email' => $email, 'id' => $_SESSION['user_id']]);
        }

        echo "Profilul a fost actualizat cu succes!";
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Eroare: " . $e->getMessage();
    }
}
?>
