<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];
$application_id = $_POST['application_id'];

if ($action == 'accept') {
    $update_sql = "UPDATE club_application SET status = 'acceptée' WHERE application_id = ?";
    $stmt = $conn->prepare($update_sql);
    if ($stmt === false) {
        error_log("Error preparing statement: " . $conn->error);
        exit("Error preparing statement");
    }
    $stmt->bind_param('i', $application_id);
    if (!$stmt->execute()) {
        error_log("Error executing statement: " . $stmt->error);
        exit("Error executing statement");
    }

    $select_sql = "SELECT * FROM club_application WHERE application_id = ?";
    $stmt = $conn->prepare($select_sql);
    if ($stmt === false) {
        error_log("Error preparing statement: " . $conn->error);
        exit("Error preparing statement");
    }
    $stmt->bind_param('i', $application_id);
    if (!$stmt->execute()) {
        error_log("Error executing statement: " . $stmt->error);
        exit("Error executing statement");
    }
    $result = $stmt->get_result();
    $app = $result->fetch_assoc();

    $insert_sql = "INSERT INTO member (club_id, role, name, classe, mail, tel, added_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($insert_sql);
    if ($stmt === false) {
        error_log("Error preparing statement: " . $conn->error);
        exit("Error preparing statement");
    }
    $stmt->bind_param('isssss', $app['club_id'], $role, $app['name'], $app['classe'], $app['mail'], $app['tel']);
    $role = 'member';
    if (!$stmt->execute()) {
        error_log("Error executing statement: " . $stmt->error);
        exit("Error executing statement");
    }
} else if ($action == 'reject') {
    $update_sql = "UPDATE application SET status = 'rejetée' WHERE application_id = ?";
    $stmt = $conn->prepare($update_sql);
    if ($stmt === false) {
        error_log("Error preparing statement: " . $conn->error);
        exit("Error preparing statement");
    }
    $stmt->bind_param('i', $application_id);
    if (!$stmt->execute()) {
        error_log("Error executing statement: " . $stmt->error);
        exit("Error executing statement");
    }
}

$conn->close();
?>
