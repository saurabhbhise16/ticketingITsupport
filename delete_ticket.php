<?php
include 'db.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $conn->query("DELETE FROM  tickets WHERE id = $id");

    $result = $conn->query("SELECT MAX(id) AS max_id FROM tickets");
    $row = $result->fetch_assoc();
    $next_id = $row['max_id'] + 1;
    $conn->query("ALTER TABLE tickets AUTO_INCREMENT = $next_id");

}

header("Location: admin.php");
exit;
    