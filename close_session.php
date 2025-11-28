<?php
$pdo = new PDO("mysql:host=localhost;dbname=school_db;charset=utf8", "root", "");

if (!isset($_POST['session_id'])) {
    echo json_encode(["error" => "Missing session_id"]);
    exit;
}

$session_id = $_POST['session_id'];

$sql = "UPDATE attendance_sessions SET status = 'closed' WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$session_id]);

echo json_encode([
    "success" => true,
    "message" => "Session closed successfully"
]);
?>
