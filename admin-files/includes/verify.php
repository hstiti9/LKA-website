<?php
session_start();

$valid_username = "Moudir";
$valid_pwd = "0000";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $pwd = $_POST['pass'];

    if ($pwd === $valid_pwd && $username === $valid_username) {
        
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin-menu.php");
        die();
    } else {
        header("Location: ../adminlogin.php");
        die();
    }
}else{
    header("Location: ../adminlogin.php");
    die();
}
?>
