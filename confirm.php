<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "UPDATE users SET is_confirmed = 1 WHERE token = :token";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $message = "Thanks for confirming your email address.";
    } else {
        $message = "Invalid token or email address.";
    }
}