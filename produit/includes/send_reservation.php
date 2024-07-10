<?php
$servername = "localhost";
$username = "RayenHaggui";
$password = "-HiBoom6969#";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = []; 
$name = '';
$classe = '';
$phone = '';
$quantity = 0;
$message = '';

function sanitizeInput($data) {
    $data = trim($data);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produit_id = $_POST['produitID'];

    if (empty($_POST["name"])) {
        $errors[] = "Name is required";
    } else {
        $name = sanitizeInput($_POST["name"]);
    }

    if (empty($_POST["classe"])) {
        $errors[] = "Classe is required";
    } else {
        $classe = sanitizeInput($_POST["classe"]);
    }

    if (empty($_POST["phone"])) {
        $errors[] = "Phone number is required";
    } else {
        $phone = sanitizeInput($_POST["phone"]);
        if (!preg_match("/^[0-9]{8,}$/", $phone)) {
            $errors[] = "Invalid phone number format";
        }
    }

    if (empty($_POST["quantité"])) {
        $errors[] = "Quantity is required";
    } else {
        $quantity = intval($_POST["quantité"]); 
        if ($quantity <= 0) {
            $errors[] = "Quantity must be greater than zero";
        }
    }

    $message = sanitizeInput($_POST["message"]);
}

if (!empty($errors)) {
    $error_message = urlencode(implode(", ", $errors));
    header("Location: ../index-produit.php?error_message=$error_message");
    exit;
} else {

    $sql = "INSERT INTO reservations (name, classe, phone, quantity, message, reservation_date, produit_id) 
            VALUES ('$name', '$classe', '$phone', $quantity, '$message', NOW(), '$produit_id')";

    if ($conn->query($sql) === TRUE) {
        $success_message = urlencode("Reservation submitted successfully.");
        header("Location: ../index-produit.php?success_message=$success_message");
        exit;
    } else {
        $error_message = urlencode("Error: " . $sql . "<br>" . $conn->error);
        header("Location: ../index-produit.php?error_message=$error_message");
        exit;
    }
}

$conn->close();
?>
