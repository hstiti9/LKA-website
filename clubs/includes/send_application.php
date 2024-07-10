<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "kheireddine";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];
$name = '';
$classe = '';
$phone = '';
$mail = '';
$message = '';

function sanitizeInput($data) {
    $data = trim($data);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produitID = $_POST["produitID"];
    $name = sanitizeInput($_POST["name"]);
    $classe = sanitizeInput($_POST["classe"]);
    $phone = sanitizeInput($_POST["phone"]);
    $mail = sanitizeInput($_POST["mail"]);
    $message = sanitizeInput($_POST["message"]);

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($classe)) {
        $errors[] = "Class is required";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match("/^([0-9]{8}|[0-9]{2} [0-9]{3} [0-9]{3})$/", $phone)) {
        $errors[] = "Invalid phone number format. Please use xxxxxxxx or xx xxx xxx format.";
    }
    

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO club_application (club_id, name, classe, tel, mail, essay) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $produitID, $name, $classe, $phone, $mail, $message);

        if ($stmt->execute()) {
            $success_message = "Application submitted successfully.";
            header("Location: ../index-clubs.php?success_message=" . urlencode($success_message));
            exit;
        } else {
            $error_message = "Error: " . $stmt->error;
            header("Location: ../index-clubs.php?error_message=" . urlencode($error_message));
            exit;
        }

        $stmt->close();
    } else {
        $error_message = implode(", ", $errors);
        header("Location: ../index-clubs.php?error_message=" . urlencode($error_message));
        exit;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
