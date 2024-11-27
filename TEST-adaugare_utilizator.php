<?php
include 'config/db.php'; 

$username = 'adminrares';
$email = 'example@example.com';
$password = 'parola';
$role = 'editor';

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'role' => $role
    ]);

    echo "Utilizatorul cu rol de editor a fost adăugat cu succes!";
} catch (PDOException $e) {
    echo "Eroare la adăugarea utilizatorului: " . $e->getMessage();
}
?>
