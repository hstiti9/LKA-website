<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$items = [];

$sql = "SELECT club_id, club_name, club_description, club_achievements, club_logo FROM club";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $club_id = $row['club_id'];

        $members_sql = "SELECT member_id, role, name FROM member WHERE club_id = $club_id";
        $members_result = $conn->query($members_sql);

        $members = [];
        if ($members_result->num_rows > 0) {
            while ($member_row = $members_result->fetch_assoc()) {
                $members[] = $member_row;
            }
        }

        $row['members'] = $members;

        $items[] = $row;
    }
}

if (!empty($items)) {
    foreach ($items as $club) {
        echo "<div class='club'>";

        echo "<h2>" . htmlspecialchars($club["club_name"]) . "</h2>";
        echo "<div class='club-details'>";

        echo '<div class="details-container">';
        if (!empty($club["club_logo"])) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($club["club_logo"]) . '" alt="Club Logo" />';
        }
        echo "<div>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($club["club_description"]) . "</p>";
        echo "<p><strong>Achievements:</strong> " . htmlspecialchars($club["club_achievements"]) . "</p>";


        if (!empty($club["members"])) {
            echo "<h3>Members:</h3>";
            echo "<ul>";
            foreach ($club["members"] as $member) {
                echo "<li>" . htmlspecialchars($member["name"]) . " - " . htmlspecialchars($member["role"]) . "</li>";
            }
            echo "</ul>";
        }
        echo "</div>";
        echo "</div>";
        echo "<button onclick='showApplicationForm(\"" . $club["club_id"] . "\", \"" . $club["club_name"] . "\")'>S'inscrire</button>";
        echo "</div>";
        
        echo "</div>";
    }
} else {
    echo "No clubs found.";
}

$conn->close();

?>
