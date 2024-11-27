<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID proiect lipsă!";
    exit;
}

$project_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM projects WHERE id = :id");
$stmt->execute(['id' => $project_id]);
$project = $stmt->fetch();

if (!$project) {
    echo "Proiectul nu există!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $budget = $_POST['budget'];

    try {
        $stmt = $conn->prepare("UPDATE projects SET title = :title, description = :description, start_date = :start_date, end_date = :end_date, budget = :budget WHERE id = :id");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'budget' => $budget,
            'id' => $project_id,
        ]);
        header("Location: manage_database.php?success=Proiect actualizat cu succes!");
        exit;
    } catch (PDOException $e) {
        $error_message = "Eroare la actualizarea proiectului: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editare Proiect</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="edit-container">
        <h1>Editare Proiect</h1>

        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="form-box">
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
                <input type="number" name="budget" id="budget" step="0.01" value="<?php echo htmlspecialchars($project['budget']); ?>" required>
            </div>
            <button type="submit" class="btn">Salvează modificările</button>
            <a href="manage_database.php" class="btn-secondary">Înapoi</a>
        </form>
    </div>
</body>
</html>
