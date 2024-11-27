<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor') {
    header("Location: login.php");
    exit;
}

$stmt = $conn->query("SELECT id, username, email, role FROM users");
$users = $stmt->fetchAll();

$stmt = $conn->query("SELECT id, title, description, start_date, end_date, budget FROM projects");
$projects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionare Utilizatori și Proiecte</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Gestionare Utilizatori și Proiecte</h1>

        <h2>Utilizatori</h2>
        <?php foreach ($users as $user): ?>
            <div class="user-box">
                <p>ID: <?php echo htmlspecialchars($user['id']); ?></p>
                <p>Nume: <?php echo htmlspecialchars($user['username']); ?></p>
                <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                <p>Rol: <?php echo htmlspecialchars($user['role']); ?></p>

                <form action="update_user.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
    <div class="input-group">
        <label for="username">Nume de utilizator</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    </div>
    <div class="input-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>
    <div class="input-group">
        <label for="role">Rol</label>
        <select name="role" id="role" required>
            <option value="viewer" <?php echo $user['role'] == 'viewer' ? 'selected' : ''; ?>>Viewer</option>
            <option value="editor" <?php echo $user['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
        </select>
    </div>
    <div class="input-group">
        <label for="password">Parolă nouă (opțional)</label>
        <input type="password" name="password" id="password">
        <small>Lasă necompletat dacă nu vrei să schimbi parola</small>
    </div>
    <button type="submit" class="btn">Salvează modificările</button>
</form>

            </div>
        <?php endforeach; ?>

        <h2>Proiecte</h2>
        <?php foreach ($projects as $project): ?>
            <div class="project-box">
                <p>ID: <?php echo htmlspecialchars($project['id']); ?></p>
                <p>Titlu: <?php echo htmlspecialchars($project['title']); ?></p>
                <p>Descriere: <?php echo htmlspecialchars($project['description']); ?></p>
                <p>Data de început: <?php echo htmlspecialchars($project['start_date']); ?></p>
                <p>Data de sfârșit: <?php echo htmlspecialchars($project['end_date']); ?></p>
                <p>Buget: <?php echo htmlspecialchars($project['budget']); ?></p>

                <form action="update_project.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($project['id']); ?>">
                    <div class="input-group">
                        <label for="title">Titlu</label>
                        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="description">Descriere</label>
                        <textarea name="description" id="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
                    </div>
                    <div class="input-group">
                        <label for="start_date">Data de început</label>
                        <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($project['start_date']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="end_date">Data de sfârșit</label>
                        <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($project['end_date']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="budget">Buget</label>
                        <input type="number" name="budget" id="budget" value="<?php echo htmlspecialchars($project['budget']); ?>" step="0.01" required>
                    </div>
                    <button type="submit">Salvează modificările</button>
                </form>

            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
