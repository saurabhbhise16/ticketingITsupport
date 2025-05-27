<?php
$conn = new mysqli("localhost", "fixuser", "Fix", "ticketing", 3307);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

?>
