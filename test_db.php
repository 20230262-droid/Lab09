<?php
require_once __DIR__ . '/../app/core/Database.php';

$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT COUNT(*) FROM students");
echo "Tổng sinh viên: " . $stmt->fetchColumn();
