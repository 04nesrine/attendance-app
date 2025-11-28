<?php
// =========================
// 1. Load students
// =========================
$students_file = "students.json";

$students = [];
if (file_exists($students_file)) {
    $json_data = file_get_contents($students_file);
    $students = json_decode($json_data, true);
}

// =========================
// 2. When form is submitted
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Build today's file name
    $today = date("Y-m-d");
    $attendance_file = "attendance_" . $today . ".json";

    // If already exists → STOP
    if (file_exists($attendance_file)) {
        echo "<h2>Attendance for today has already been taken.</h2>";
        exit;
    }

    // Build attendance array
    $attendance = [];

    foreach ($students as $student) {
        $id = $student["student_id"];
        $status = isset($_POST["status_$id"]) ? $_POST["status_$id"] : "absent";

        $attendance[] = [
            "student_id" => $id,
            "status" => $status
        ];
    }

    // Save JSON file
    file_put_contents($attendance_file, json_encode($attendance, JSON_PRETTY_PRINT));

    echo "<h2>Attendance saved successfully for $today.</h2>";
    echo "<a href='take_attendance.php'>Back</a>";
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Take Attendance</title>
</head>
<body>

<h2>Take Attendance</h2>

<form method="POST">

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Group</th>
        <th>Status</th>
    </tr>

    <?php foreach ($students as $st): ?>
        <tr>
            <td><?= $st["student_id"] ?></td>
            <td><?= $st["name"] ?></td>
            <td><?= $st["group"] ?></td>

            <td>
                <label>
                    <input type="radio" name="status_<?= $st["student_id"] ?>" value="present" required> Present
                </label>
                <label>
                    <input type="radio" name="status_<?= $st["student_id"] ?>" value="absent"> Absent
                </label>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<br>
<button type="submit">Save Attendance</button>

</form>

</body>
</html>
