<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $budget = $_POST['budget'];

    if (empty($title) || empty($description) || empty($start_date) || empty($end_date) || empty($budget)) {
        echo "Toate câmpurile sunt obligatorii!";
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE projects SET title = :title, description = :description, start_date = :start_date, end_date = :end_date, budget = :budget WHERE id = :id");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'budget' => $budget,
            'id' => $id,
        ]);

        header("Location: manage_database.php?message=project_updated");
        exit;
    } catch (PDOException $e) {
        echo "Eroare la actualizarea proiectului: " . $e->getMessage();
        exit;
    }
}

?>
