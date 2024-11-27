<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->rowCount() > 0) {
        $error = "Utilizatorul sau email-ul există deja!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'viewer')");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
        $success = "Contul a fost creat cu succes! <a href='login.php'>Autentifică-te aici</a>.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="form-container">
        <form method="POST" class="form-box">
            <h1>Înregistrare</h1>
            <?php if (isset($error)) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php elseif (isset($success)) : ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <label for="username">Nume utilizator</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="input-group">
                <label for="password">Parolă</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Înregistrează-te</button>
            <p class="form-link">Ai deja un cont? <a href="login.php">Autentifică-te</a></p>
        </form>
        <a href="index.php" class="btn-secondary">Înapoi la pagina principală</a>
    </div>
</body>
</html>
