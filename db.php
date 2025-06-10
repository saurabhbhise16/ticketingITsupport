<?php
$conn = new mysqli("localhost", "root", "", "", 3306);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS ticketing";
if (!$conn->query($sql)) {
    die("❌ Database creation failed: " . $conn->error);
}

$conn->select_db("ticketing");

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

?>
