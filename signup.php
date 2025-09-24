<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                echo "Sign up successful!";
            } else {
                echo "Error inserting user: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "SQL error: " . $conn->error;
        }

    } else {
        echo "Please fill in all fields.";
    }
}

$conn->close();
?>
