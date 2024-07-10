<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];

    try {
        switch ($type) {
            case 'club':
                deleteClub();
                break;
            case 'member':
                deleteMember();
                break;
            default:
                throw new Exception("Type non valide pour la suppression.");
        }
    } catch (Exception $e) {
        $msg = "Erreur: " . $e->getMessage();
    }

    $conn->close();

    echo $msg;

    exit;  
} else {
    echo "Méthode non autorisée.";
}

function deleteClub() {
    global $conn;
    if (isset($_POST['clubId'])) {
        $clubId = $_POST['clubId'];
        $stmt = $conn->prepare("DELETE FROM club WHERE club_id = ?");
        $stmt->bind_param("i", $clubId);
        if ($stmt->execute()) {
            echo "Club supprimé avec succès.";
        } else {
            throw new Exception("Erreur lors de la suppression du club: " . $stmt->error);
        }
        $stmt->close();
    } else {
        throw new Exception("ID du club non spécifié.");
    }
}

function deleteMember() {
    global $conn;
    if (isset($_POST['memberId'])) {
        $memberId = $_POST['memberId'];
        $stmt = $conn->prepare("DELETE FROM members WHERE member_id = ?");
        $stmt->bind_param("i", $memberId);
        if ($stmt->execute()) {
            echo "Membre supprimé avec succès.";
        } else {
            throw new Exception("Erreur lors de la suppression du membre: " . $stmt->error);
        }
        $stmt->close();
    } else {
        throw new Exception("ID du membre non spécifié.");
    }
}
?>
