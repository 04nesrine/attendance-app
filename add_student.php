<?php
// ---------------------------
// 1. Récupération du formulaire
// ---------------------------
$student_id = trim($_POST["student_id"] ?? "");
$name       = trim($_POST["name"] ?? "");
$group      = trim($_POST["group"] ?? "");

// ---------------------------
// 2. Validation des champs
// ---------------------------
$errors = [];

if ($student_id === "" || !ctype_digit($student_id)) {
    $errors[] = "Student ID must be numeric.";
}

if ($name === "" || !preg_match("/^[a-zA-Z ]+$/", $name)) {
    $errors[] = "Name must contain only letters.";
}

if ($group === "") {
    $errors[] = "Group cannot be empty.";
}

// Si erreurs → afficher et arrêter
if (!empty($errors)) {
    echo "<h3>❌ Errors:</h3>";
    foreach ($errors as $e) {
        echo "<p>- $e</p>";
    }
    exit;
}

// ---------------------------
// 3. Charger students.json
// ---------------------------
$file = "students.json";
$students = [];

// Si le fichier existe → on lit son contenu
if (file_exists($file)) {
    $students = json_decode(file_get_contents($file), true);
    if (!is_array($students)) $students = [];
}

// ---------------------------
// 4. Ajouter l'étudiant
// ---------------------------
$new_student = [
    "student_id" => $student_id,
    "name"       => $name,
    "group"      => $group
];

$students[] = $new_student;

// ---------------------------
// 5. Sauvegarder dans students.json
// ---------------------------
file_put_contents($file, json_encode($students, JSON_PRETTY_PRINT));

// ---------------------------
// 6. Message de confirmation
// ---------------------------
echo "<h2>✔ Student added successfully!</h2>";
echo "<p><strong>ID:</strong> $student_id</p>";
echo "<p><strong>Name:</strong> $name</p>";
echo "<p><strong>Group:</strong> $group</p>";

?>
