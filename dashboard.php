<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "Eroare: Utilizatorul nu există.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilul meu</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Bun venit, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p>Rol: <?php echo htmlspecialchars($user['role']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        
        <h2>Modifică datele tale</h2>
        <form action="update_profile.php" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="input-group">
                <label for="password">Parolă nouă</label>
                <input type="password" name="password" id="password">
                <small>Lasă necompletat pentru a nu schimba parola</small>
            </div>
            <button type="submit" class="btn">Salvează modificările</button>
        </form>

        <?php if ($user['role'] === 'viewer') : ?>
            <h2>Funcționalități pentru Viewer</h2>
            <a href="donations/make_donation.php" class="btn">Fă o donație</a>
            <a href="projects/apply_project.php" class="btn">Aplică la un proiect</a>
        <?php elseif ($user['role'] === 'editor') : ?>
            <h2>Funcționalități pentru Editor</h2>
            <a href="donations/make_donation.php" class="btn">Fă o donație</a>
            <a href="projects/apply_project.php" class="btn">Aplică la un proiect</a>
            <a href="database/manage_database.php" class="btn">Modifica baza de date</a>
            <a href="projects/edit.php" class="btn">Modifica proiecte</a>
        <?php endif; ?>

        <a href="logout.php" class="btn-secondary">Deconectare</a>
    </div>
</body>
</html>
