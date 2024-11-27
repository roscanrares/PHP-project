<?php
session_start();
include '../config/db.php';  

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE users SET username = :username, email = :email, role = :role, password = :password WHERE id = :id";
        $params = ['username' => $username, 'email' => $email, 'role' => $role, 'password' => $hashedPassword, 'id' => $id];
    } else {
        $query = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
        $params = ['username' => $username, 'email' => $email, 'role' => $role, 'id' => $id];
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    echo "Utilizatorul a fost actualizat cu succes!";
    header("Location: manage_database.php");
    exit;
}

?>
