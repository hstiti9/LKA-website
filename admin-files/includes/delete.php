<?php
$servername = "localhost";
$username = "RayenHaggui";
$password = "-HiBoom6969#";
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
            case 'delete-event':
                $event_name = $_POST["eventName"];

                $stmt = $conn->prepare("DELETE FROM evennement WHERE event_name = ?");
                $stmt->bind_param("s", $event_name);

                if ($stmt->execute()) {
                    $msg = "Evennement supprimé avec succès";
                } else {
                    throw new Exception("Error deleting event record: " . $stmt->error);
                }

                $stmt->close();
                break;

            case 'delete-product':
                $product_name = $_POST["productName"];

                $stmt = $conn->prepare("DELETE FROM produit WHERE produit_name = ?");
                $stmt->bind_param("s", $product_name);

                if ($stmt->execute()) {
                    $msg = "Produit supprimé avec succès";
                } else {
                    throw new Exception("Error deleting product record: " . $stmt->error);
                }

                $stmt->close();
                break;

            default:
                throw new Exception("Invalid request type.");
        }
    } catch (Exception $e) {
        $msg = "Erreur: " . $e->getMessage();
    }

    $conn->close();

    header("Location: Dashboard.php?msg=" . urlencode($msg));
    die();
}
?>
