<?php
session_start();
include '../config/db.php';

$stmt = $conn->query("SELECT * FROM projects");
$projects = $stmt->fetchAll();

foreach ($projects as $project) {
    echo "<h2>{$project['title']}</h2>";
    echo "<p>{$project['description']}</p>";
    echo "<p>Buget: {$project['budget']} RON</p>";
}
?>
