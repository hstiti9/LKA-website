<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT produit_id, produit_name, produit_description, price, quantity, produit_img FROM produit ORDER BY produit_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='event'>";
        echo "<h2>" . htmlspecialchars($row["produit_name"]) . "</h2>";
        echo "<div class='eventet'>";
        if ($row["produit_img"]) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row["produit_img"]) . '" alt="Product Image" />';
        }
        echo "<div class='jaw'>";
        echo "<p><strong>Description: </strong>" . htmlspecialchars($row["produit_description"]) . "</p>";
        echo "<p><strong>Prix:</strong> " . htmlspecialchars($row["price"]) . "DT</p>";
        echo "<p><strong>Quantité en stock:</strong> " . htmlspecialchars($row["quantity"]) . "</p>";
        echo "<button onclick='showReservationForm(" . $row["produit_id"] . ", \"" . addslashes($row["produit_name"]) . "\", " . $row["price"] . ")'>Reserver</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No products found.";
}

$conn->close();
?>
