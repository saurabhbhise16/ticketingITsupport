<?php include 'db.php'; ?>

<?php
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['name'], $_POST['email'], $_POST['issue_type'], $_POST['priority'], $_POST['message'])) {

        if (empty($_POST['priority'])) {
            $error = "❌ Error: Priority is required.";
        } else {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $issue_type = $_POST['issue_type'];
            $priority = $_POST['priority'];
            $message = $_POST['message'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "❌ Error: Invalid email format.";
            } else {
                // Create table if it doesn't exist
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
                        assigned_to VARCHAR(255), 
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";
                    if (!$conn->query($createTableSql)) {
                        $error = "❌ Error creating table: " . $conn->error;
                    }
                }

                // Get assigned worker from Work_Assign
                $result = $conn->query("SELECT next_index FROM Work_Assign");
                $row = $result ? $result->fetch_assoc() : null;
                $next_index = $row ? $row['next_index'] : null;

                if ($next_index !== null) {
                    $assigned_query = $conn->prepare("SELECT Name FROM IT_wrkers WHERE Id = ?");
                    $assigned_query->bind_param("i", $next_index);
                    $assigned_query->execute();
                    $assigned_result = $assigned_query->get_result();

                    if ($assigned_result && $assigned_result->num_rows > 0) {
                        $assigned_to = $assigned_result->fetch_assoc()['Name'];
                        $status = 'Open';

                        // Insert ticket
                        $stmt = $conn->prepare("INSERT INTO tickets (name, email, issue_type, message, priority, status, assigned_to) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        if (!$stmt) {
                            $error = "Prepare failed: " . $conn->error;
                        } else {
                            $stmt->bind_param("sssssss", $name, $email, $issue_type, $message, $priority, $status, $assigned_to);

                            if ($stmt->execute()) {
                                // Update round-robin indexes
                                $update_indexes_sql = "
                                    UPDATE Work_Assign
                                    SET
                                      cur_index = next_index,
                                      next_index = CASE
                                                     WHEN next_index >= (SELECT COUNT(*) FROM IT_wrkers) THEN 1
                                                     ELSE next_index + 1
                                                   END
                                ";
                                if (!$conn->query($update_indexes_sql)) {
                                    $error = "❌ Failed to update work assignment indexes: " . $conn->error;
                                } else {
                                    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                                    exit();
                                }
                            } else {
                                $error = "❌ Failed to submit ticket: " . $stmt->error;
                            }

                            $stmt->close();
                        }
                    } else {
                        $error = "❌ Could not find assigned worker for index: " . htmlspecialchars($next_index);
                        error_log("No assigned worker found. next_index = " . htmlspecialchars($next_index));
                    }
                    $assigned_query->close();
                } else {
                    $error = "❌ Failed to retrieve next worker index.";
                }
            }
        }
    }
}
?>

<h2>Submit a Support Ticket</h2>

<?php if ($error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
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
diya_bhat
<br><a href='admin.php?id={$row['id']}'>Back to Admin</a></br>

<script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/06/03/04/20250603040323-KED2C522.js"></script>

