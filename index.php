<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $issue_type = $_POST['issue_type'];
    $message = $_POST['message'];

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO tickets (name, email, issue_type, message) VALUES (?, ?, ?, ?)");

    // Check for errors in prepare
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind and execute
    $stmt->bind_param("ssss", $name, $email, $issue_type, $message);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "✅ Ticket submitted successfully!";
    } else {
        echo "❌ Failed to submit ticket.";
    }

    $stmt->close();
}
?>

<h2>Submit a Support Ticket</h2>
<form method="post">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Issue Type:
    <select name="issue_type">
        <option>OS Support</option>
        <option>Printer Support</option>
        <option>Network</option>
    </select><br>
    Message:<br>
    <textarea name="message" rows="5" cols="30"></textarea><br>
    <input type="submit" value="Submit Ticket">
</form>
