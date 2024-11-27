<?php
session_start();
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Nume utilizator sau parolă incorectă!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="form-container">
        <form method="POST" class="form-box">
            <h1>Autentificare</h1>
            <?php if (isset($error)) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <label for="username">Nume utilizator</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Parolă</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Autentificare</button>
            <p class="form-link">Nu ai un cont? <a href="register.php">Înregistrează-te</a></p>
        </form>
        <a href="index.php" class="btn-secondary">Înapoi la pagina principală</a>
    </div>
</body>
</html>
