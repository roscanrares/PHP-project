<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_user':
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $role = $_POST['role'];

                $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
                $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role,
                ]);
                break;

            case 'edit_user':
                $id = $_POST['id'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

                if ($password) {
                    $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, role = :role, password = :password WHERE id = :id");
                    $stmt->execute([
                        'username' => $username,
                        'email' => $email,
                        'role' => $role,
                        'password' => $password,
                        'id' => $id,
                    ]);
                } else {
                    $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
                    $stmt->execute([
                        'username' => $username,
                        'email' => $email,
                        'role' => $role,
                        'id' => $id,
                    ]);
                }
                break;

            case 'delete_user':
                $id = $_POST['id'];
                $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
                $stmt->execute(['id' => $id]);
                break;

            case 'add_project':
                $title = $_POST['title'];
                $description = $_POST['description'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $budget = $_POST['budget'];

                $stmt = $conn->prepare("INSERT INTO projects (title, description, start_date, end_date, budget) VALUES (:title, :description, :start_date, :end_date, :budget)");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'budget' => $budget,
                ]);
                break;

            case 'edit_project':
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $budget = $_POST['budget'];

                $stmt = $conn->prepare("UPDATE projects SET title = :title, description = :description, start_date = :start_date, end_date = :end_date, budget = :budget WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'budget' => $budget,
                    'id' => $id,
                ]);
                break;

            case 'delete_project':
                $id = $_POST['id'];
                $stmt = $conn->prepare("DELETE FROM projects WHERE id = :id");
                $stmt->execute(['id' => $id]);
                break;
        }
    }
}

$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll();

$stmt = $conn->query("SELECT * FROM projects WHERE title IS NOT NULL AND description IS NOT NULL AND start_date IS NOT NULL AND end_date IS NOT NULL AND budget IS NOT NULL");
$projects = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Database</title>
    <button class="toggle-bar">Meniu</button>
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="../assets/script.js"></script>

    
</head>
<header class="hover-expand-header">
    <div class="header-title">Gestionare Utilizatori și Proiecte</div>
    <div class="nav-links">
        <a href="../dashboard.php">Dashboard</a>
        <a href="../projects/apply_project.php">Aplică la proiect</a>
        <a href="../donations/make_donation.php">Fă o donație</a>
        <a href="../logout.php">Deconectare</a>
    </div>
</header>


<body>
    <div class="manage-database-container">
        <h1>Gestionare Utilizatori și Proiecte</h1>

        <h2>Gestionare Utilizatori</h2>
        <form action="manage_database.php" method="POST" class="form-box">
            <input type="hidden" name="action" value="add_user">
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
            <div class="input-group">
                <label for="role">Rol</label>
                <select name="role" id="role" required>
                    <option value="viewer">Viewer</option>
                    <option value="editor">Editor</option>
                </select>
            </div>
            <button type="submit" class="btn">Adaugă utilizator</button>
        </form>

        <h3>Utilizatori existenți</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <form action="edit_user.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-secondary">Editează</button>
                            </form>

                            <form action="manage_database.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete_user">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-danger">Șterge</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Gestionare Proiecte</h2>
        <form action="manage_database.php" method="POST" class="form-box">
            <input type="hidden" name="action" value="add_project">
            <div class="input-group">
                <label for="title">Titlu</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="input-group">
                <label for="description">Descriere</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="input-group">
                <label for="start_date">Data de început</label>
                <input type="date" name="start_date" id="start_date" required>
            </div>
            <div class="input-group">
                <label for="end_date">Data de sfârșit</label>
                <input type="date" name="end_date" id="end_date" required>
            </div>
            <div class="input-group">
                <label for="budget">Buget</label>
                <input type="number" name="budget" id="budget" step="0.01" required>
            </div>
            <button type="submit" class="btn">Adaugă proiect</button>
        </form>

        <h3>Proiecte existente</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titlu</th>
                    <th>Descriere</th>
                    <th>Data de început</th>
                    <th>Data de sfârșit</th>
                    <th>Buget</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['id']); ?></td>
                        <td><?php echo htmlspecialchars($project['title']); ?></td>
                        <td><?php echo htmlspecialchars($project['description']); ?></td>
                        <td><?php echo htmlspecialchars($project['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($project['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($project['budget']); ?></td>
                        <td>
                            <form action="edit_project.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                <button type="submit" class="btn btn-secondary">Editează</button>
                            </form>


                            <form action="manage_database.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete_project">
                                <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                <button type="submit" class="btn btn-danger">Șterge</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
