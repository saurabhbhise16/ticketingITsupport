<?php include 'db.php'; ?>

<?php

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['name'], $_POST['email'], $_POST['issue_type'], $_POST['priority'], $_POST['message'])) {

        if (empty($_POST['priority'])) {
            $error = "❌ Error: Priority is required.";
        }
        else{
            $name = $_POST['name'];
            $email = $_POST['email'];
            $issue_type = $_POST['issue_type'];
            $priority = $_POST['priority']; 
            $message = $_POST['message'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "❌ Error: Invalid email format.";
            }
            else{

            // Prepare statement
            // Check if the table exists, if not, create it
            $tableCheck = $conn->query("SHOW TABLES LIKE 'tickets'");
            if ($tableCheck->num_rows == 0) {
                $createTableSql = "CREATE TABLE tickets (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    issue_type VARCHAR(100) NOT NULL,
                    message TEXT,
                    priority VARCHAR(20) NOT NULL,
                    status ENUM('Open', 'In Progress', 'Closed') DEFAULT 'Open',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                if (!$conn->query($createTableSql)) {
                    $error = "❌ Error creating table: " . $conn->error;
                }
            }

            $stmt = $conn->prepare("INSERT INTO tickets (name, email, issue_type, message, priority) VALUES (?, ?, ?, ?, ?)");

            if(!$stmt){
                $error = "Prepare failed: " . $conn->error;
            } else {

                $stmt->bind_param("sssss",$name, $email, $issue_type, $message, $priority);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                    exit();
                } else {
                    $error = "❌ Failed to submit ticket.";
                }
                $stmt->close();
            }
        }
    } 
    }
}
    
?>

<h2>Submit a Support Ticket</h2>

<?php if ($error): ?>
    <p style = "color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">✅ Ticket submitted successfully!</p>
<?php endif; ?>

<form method="post">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Issue Type:
    <select name="issue_type">
        <option>OS Support</option>
        <option>Printer Support</option>
        <option>Network</option>
    </select><br>
    Priority Type:
    <select name="priority" required>
        <option value="" disabled selected>-- Select Priority --</option>
        <option>High</option>
        <option>Medium</option>
        <option>Low</option>
    </select><br>

    Message:<br>
    <textarea name="message" rows="5" cols="30"></textarea><br>
    <input type="submit" value="Submit Ticket">
</form>
<br><a href='admin.php?id={$row['id']}'>Back to Admin</a></br>