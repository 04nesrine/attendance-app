<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=school_db;charset=utf8", "root", "");

// Check required fields
if (!isset($_POST['course_id'], $_POST['group_id'], $_POST['opened_by'])) {
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$course_id = $_POST['course_id'];
$group_id = $_POST['group_id'];
$opened_by = $_POST['opened_by'];

$sql = "INSERT INTO attendance_sessions (course_id, group_id, opened_by)
        VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$course_id, $group_id, $opened_by]);

$session_id = $pdo->lastInsertId();

echo json_encode([
    "success" => true,
    "session_id" => $session_id
]);
?>
