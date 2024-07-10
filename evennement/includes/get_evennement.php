<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT event_name, event_description, event_img FROM evennement ORDER BY event_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='event'>";
        echo "<h2>" . htmlspecialchars($row["event_name"]) . "</h2>";
        echo "<div class='eventet'>";
        if ($row["event_img"]) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row["event_img"]) . '" alt="Event Image" />';
        }
        echo "<p>" . "<strong>Description: </strong>" . htmlspecialchars($row["event_description"]) . "</p>";

        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No events found.";
}

$conn->close();
?>
