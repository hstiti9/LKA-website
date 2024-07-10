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
            case 'product':
                $produit_name = $_POST["productName"];
                $produit_description = $_POST["description"];
                $price = $_POST["price"];
                $quantity = $_POST["quantity"];

                if ($_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
                    throw new Exception("Error uploading file.");
                }

                $photo = $_FILES["photo"];
                $photoType = $photo["type"];
                $photoSize = $photo["size"];
                $maxSize = 10 * 1024 * 1024;

                if ($photoType !== 'image/jpeg' || $photoSize > $maxSize) {
                    throw new Exception("Invalid file type or size. Only JPEG images are allowed and size should be <= 10MB.");
                }

                list($width, $height) = getimagesize($photo["tmp_name"]);
                if ($width > 5000 || $height > 5000) {
                    throw new Exception("Image dimensions are too large.");
                }

                $produit_img_tmp = $photo["tmp_name"];
                $produit_img = file_get_contents($produit_img_tmp);

                $stmt = $conn->prepare("INSERT INTO produit (produit_name, produit_description, price, quantity, produit_img) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssids", $produit_name, $produit_description, $price, $quantity, $produit_img);

                if ($stmt->execute()) {
                    $msg = "produit ajouté avec succès";
                } else {
                    throw new Exception("Error inserting product record: " . $stmt->error);
                }

                $stmt->close();
                break;

            case 'event':
                $event_name = $_POST["eventName"];
                $event_description = $_POST["description"];

                if ($_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
                    throw new Exception("Error uploading file.");
                }

                $photo = $_FILES["photo"];
                $photoType = $photo["type"];
                $photoSize = $photo["size"];
                $maxSize = 10 * 1024 * 1024;

                if ($photoType !== 'image/jpeg' || $photoSize > $maxSize) {
                    throw new Exception("Invalid file type or size. Only JPEG images are allowed and size should be <= 10MB.");
                }

                list($width, $height) = getimagesize($photo["tmp_name"]);
                if ($width > 5000 || $height > 5000) {
                    throw new Exception("Image dimensions are too large.");
                }

                $event_img_tmp = $photo["tmp_name"];
                $event_img = file_get_contents($event_img_tmp);

                $stmt = $conn->prepare("INSERT INTO evennement (event_name, event_description, event_img) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $event_name, $event_description, $event_img);

                if ($stmt->execute()) {
                    $msg = "evennement ajouté avec succès";
                } else {
                    throw new Exception("Error inserting event record: " . $stmt->error);
                }

                $stmt->close();
                break;

            case 'modif-event':
                $event_name = $_POST["eventName"];
                $new_event_name = $_POST["newEvennementName"];
                $event_description = $_POST["description"];

                $check_query = "SELECT COUNT(*) FROM evennement WHERE event_name = ?";
                $stmt = $conn->prepare($check_query);
                $stmt->bind_param("s", $event_name);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count == 0) {
                    $msg = "l'evennement n'existe pas";
                    break;
                }

                $query = "UPDATE evennement SET ";
                $params = [];
                $types = "";

                if (!empty($new_event_name)) {
                    $query .= "event_name = ?, ";
                    $params[] = $new_event_name;
                    $types .= "s";
                }

                if (!empty($event_description)) {
                    $query .= "event_description = ?, ";
                    $params[] = $event_description;
                    $types .= "s";
                }

                if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
                    $photo = $_FILES["photo"];
                    $photoType = $photo["type"];
                    $photoSize = $photo["size"];
                    $maxSize = 10 * 1024 * 1024;

                    if ($photoType !== 'image/jpeg' || $photoSize > $maxSize) {
                        throw new Exception("Invalid file type or size. Only JPEG images are allowed and size should be <= 10MB.");
                    }

                    list($width, $height) = getimagesize($photo["tmp_name"]);
                    if ($width > 5000 || $height > 5000) {
                        throw new Exception("Image dimensions are too large.");
                    }

                    $event_img_tmp = $photo["tmp_name"];
                    $event_img = file_get_contents($event_img_tmp);

                    $query .= "event_img = ?, ";
                    $params[] = $event_img;
                    $types .= "s";
                }

                if (!empty($params)) {
                    $query = rtrim($query, ", ") . " WHERE event_name = ?";
                    $params[] = $event_name;
                    $types .= "s";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param($types, ...$params);

                    if ($stmt->execute()) {
                        $msg = "evennement modifié avec succès";
                    } else {
                        throw new Exception("Error updating event record: " . $stmt->error);
                    }

                    $stmt->close();
                } else {
                    $msg = "No changes were made.";
                }
                break;

            case 'modif-product':
                $product_name = $_POST["productName"];
                $new_product_name = $_POST["newProductName"];
                $product_description = $_POST["description"];
                $price = $_POST["price"];
                $quantity = $_POST["quantity"];

                $check_query = "SELECT COUNT(*) FROM produit WHERE produit_name = ?";
                $stmt = $conn->prepare($check_query);
                $stmt->bind_param("s", $product_name);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count == 0) {
                    $msg = "le produit n'existe pas";
                    break;
                }

                $query = "UPDATE produit SET ";
                $params = [];
                $types = "";

                if (!empty($new_product_name)) {
                    $query .= "produit_name = ?, ";
                    $params[] = $new_product_name;
                    $types .= "s";
                }

                if (!empty($product_description)) {
                    $query .= "produit_description = ?, ";
                    $params[] = $product_description;
                    $types .= "s";
                }

                if (!empty($price)) {
                    $query .= "price = ?, ";
                    $params[] = $price;
                    $types .= "d";
                }

                if (!empty($quantity)) {
                    $query .= "quantity = ?, ";
                    $params[] = $quantity;
                    $types .= "i";
                }

                if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
                    $photo = $_FILES["photo"];
                    $photoType = $photo["type"];
                    $photoSize = $photo["size"];
                    $maxSize = 10 * 1024 * 1024;

                    if ($photoType !== 'image/jpeg' || $photoSize > $maxSize) {
                        throw new Exception("Invalid file type or size. Only JPEG images are allowed and size should be <= 10MB.");
                    }

                    list($width, $height) = getimagesize($photo["tmp_name"]);
                    if ($width > 5000 || $height > 5000) {
                        throw new Exception("Image dimensions are too large.");
                    }

                    $product_img_tmp = $photo["tmp_name"];
                    $product_img = file_get_contents($product_img_tmp);

                    $query .= "produit_img = ?, ";
                    $params[] = $product_img;
                    $types .= "s";
                }

                if (!empty($params)) {
                    $query = rtrim($query, ", ") . " WHERE produit_name = ?";
                    $params[] = $product_name;
                    $types .= "s";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param($types, ...$params);

                    if ($stmt->execute()) {
                        $msg = "produit modifié avec succès";
                    } else {
                        throw new Exception("Error updating product record: " . $stmt->error);
                    }

                    $stmt->close();
                } else {
                    $msg = "No changes were made.";
                }
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

