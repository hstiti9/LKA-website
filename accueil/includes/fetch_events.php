<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT event_name, event_img FROM evennement ORDER BY creation_date DESC LIMIT 3";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['event_img'] = base64_encode($row['event_img']);
        $events[] = $row;
    }
}

$conn->close();

echo json_encode($events);
?>
