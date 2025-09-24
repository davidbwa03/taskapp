<?php
include 'db.php';


$sql = "SELECT username, email FROM users ORDER BY username ASC";
$result = $conn->query($sql);

echo "<h2>Registered Users</h2>";

if ($result->num_rows > 0) {
    echo "<ol>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['username']) . " - " . htmlspecialchars($row['email']) . "</li>";
    }
    echo "</ol>";
} else {
    echo "No users founded";
}

$conn->close();
?>