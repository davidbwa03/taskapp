<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db.php'; // use your db connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        // check if user exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // success -> store session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: users.php");
                    exit;
                } else {
                    echo "<p style='color:red;'>Invalid password!</p>";
                }
            } else {
                echo "<p style='color:red;'>No account found with that email.</p>";
            }
        } else {
            echo "<p style='color:red;'>Query failed: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Please fill in all fields.</p>";
    }
}
?>
