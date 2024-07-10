<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_GET['type'];
$items = [];

if ($type == 'event') {
    $sql = "SELECT event_name FROM evennement";
} else if ($type == 'product') {
    $sql = "SELECT produit_name FROM produit";
} else if ($type == 'club') {
    $sql = "SELECT club_id, club_name FROM club";
} else if ($type == 'member') {
    $sql = "SELECT member_id, name FROM member"; 
} else if ($type == 'application') {
    $sql = "SELECT application_id, club_id, name, classe, tel, mail, essay, status FROM club_application"; 
} else if ($type == 'club_member'){
    $sql = "SELECT member_id, name FROM member WHERE club_id = searched_club_id"; 
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

$conn->close();

echo json_encode($items);
?>
