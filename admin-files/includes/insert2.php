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
                $club_name = $_POST["clubName"];
                $club_description = $_POST["clubDescription"];
                $club_achievements = $_POST["clubAchievements"];
                $club_logo = null;

                if ($_FILES["clubLogo"]["error"] === UPLOAD_ERR_OK) {
                    $logo = $_FILES["clubLogo"];
                    $logoType = $logo["type"];
                    $logoSize = $logo["size"];
                    $maxSize = 10 * 1024 * 1024;

                    if ($logoType !== 'image/jpeg' || $logoSize > $maxSize) {
                        throw new Exception("Invalid file type or size. Only JPEG images are allowed and size should be <= 10MB.");
                    }

                    list($width, $height) = getimagesize($logo["tmp_name"]);
                    if ($width > 5000 || $height > 5000) {
                        throw new Exception("Image dimensions are too large.");
                    }

                    $club_logo_tmp = $logo["tmp_name"];
                    $club_logo = file_get_contents($club_logo_tmp);
                }

                $stmt = $conn->prepare("INSERT INTO club (club_name, club_description, club_achievements, club_logo) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $club_name, $club_description, $club_achievements, $club_logo);

                if ($stmt->execute()) {
                    $msg = "Club ajouté avec succès";
                } else {
                    throw new Exception("Error inserting club record: " . $stmt->error);
                }

                $stmt->close();
                break;

            case 'modif-club':
                $club_id = $_POST["clubId"];
                $new_club_name = $_POST["newClubName"];
                $club_description = $_POST["clubDescription"];
                $club_achievements = $_POST["clubAchievements"];
                $club_logo = null;

                if ($_FILES["clubLogo"]["error"] === UPLOAD_ERR_OK) {
                    $logo = $_FILES["clubLogo"];
                    $logoType = $logo["type"];
                    $logoSize = $logo["size"];
                    $maxSize = 10 * 1024 * 1024;

                    if ($logoType !== 'image/jpeg' || $logoSize > $maxSize) {
                        throw new Exception("Invalid file type or size. Only JPEG images are allowed and size should be <= 10MB.");
                    }

                    list($width, $height) = getimagesize($logo["tmp_name"]);
                    if ($width > 5000 || $height > 5000) {
                        throw new Exception("Image dimensions are too large.");
                    }

                    $club_logo_tmp = $logo["tmp_name"];
                    $club_logo = file_get_contents($club_logo_tmp);
                }

                $query = "UPDATE club SET ";
                $params = [];
                $types = "";

                if (!empty($new_club_name)) {
                    $query .= "club_name = ?, ";
                    $params[] = $new_club_name;
                    $types .= "s";
                }

                if (!empty($club_description)) {
                    $query .= "club_description = ?, ";
                    $params[] = $club_description;
                    $types .= "s";
                }

                if (!empty($club_achievements)) {
                    $query .= "club_achievements = ?, ";
                    $params[] = $club_achievements;
                    $types .= "s";
                }

                if (!empty($club_logo)) {
                    $query .= "club_logo = ?, ";
                    $params[] = $club_logo;
                    $types .= "s";
                }

                if (!empty($params)) {
                    $query = rtrim($query, ", ") . " WHERE club_id = ?";
                    $params[] = $club_id;
                    $types .= "i";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param($types, ...$params);

                    if ($stmt->execute()) {
                        $msg = "Club modifié avec succès";
                    } else {
                        throw new Exception("Error updating club record: " . $stmt->error);
                    }

                    $stmt->close();
                } else {
                    $msg = "No changes were made.";
                }
                break;

            case 'modif-member':
                $club_id = $_POST["clubId"];
                $member_id = $_POST["memberId"];
                $new_member_name = $_POST["newMemberName"];
                $role = $_POST["role"];
                $classe = $_POST["classe"];
                $email = $_POST["mail"];
                $telephone = $_POST["tel"];

                $query = "UPDATE member SET ";
                $params = [];
                $types = "";

                if (!empty($new_member_name)) {
                    $query .= "member_name = ?, ";
                    $params[] = $new_member_name;
                    $types .= "s";
                }

                if (!empty($role)) {
                    $query .= "role = ?, ";
                    $params[] = $role;
                    $types .= "s";
                }

                if (!empty($classe)) {
                    $query .= "classe = ?, ";
                    $params[] = $classe;
                    $types .= "s";
                }

                if (!empty($email)) {
                    $query .= "email = ?, ";
                    $params[] = $email;
                    $types .= "s";
                }

                if (!empty($telephone)) {
                    $query .= "telephone = ?, ";
                    $params[] = $telephone;
                    $types .= "s";
                }

                if (!empty($params)) {
                    $query = rtrim($query, ", ") . " WHERE member_id = ?";
                    $params[] = $member_id;
                    $types .= "i";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param($types, ...$params);

                    if ($stmt->execute()) {
                        $msg = "Member modifié avec succès";
                    } else {
                        throw new Exception("Error updating member record: " . $stmt->error);
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

    header("Location: Dashboard2.php?msg=" . urlencode($msg));
    die();
}
?>
