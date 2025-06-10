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
                // Create table if not exists
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

                // Assign worker
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

                        $stmt = $conn->prepare("INSERT INTO tickets (name, email, issue_type, message, priority, status, assigned_to) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        if (!$stmt) {
                            $error = "Prepare failed: " . $conn->error;
                        } else {
                            $stmt->bind_param("sssssss", $name, $email, $issue_type, $message, $priority, $status, $assigned_to);
                            if ($stmt->execute()) {
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

<!DOCTYPE html>
<html>
<head>
    <title>Ticket Submission</title>
    
    <style>
        .image-wrapper {
            position: absolute;
            padding-top: 200px;
            padding-left: 390px;
        }

        .image-wrapper img{
            height: 300px;
            max-width: 100%;
            object-fit: contain;
        }

        img{
            display: flex;
            justify-content: center;
            height: 300px;
            
        }
        
        body {
            font-family: 'Segoe UI', sans-serif;
            background:rgb(255, 255, 255);
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100vh;
            
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            z-index: 1;
        }

        form {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            line-height: 1.6;
            background-color: black
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: white
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .message.error {
            color: red;
        }

        .message.success {
            color: green;
        }
    </style>
</head>
<body>

<div class="image-wrapper">
    <img src="https://i.pinimg.com/736x/e3/37/db/e337dbc48036c712cf6ae5a6128c80ff.jpg">
    </div>

<div class="form-container">
    <form method="post">
        <h2>Submit a Support Ticket</h2>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="message success">✅ Ticket submitted successfully!</div>
        <?php endif; ?>

        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="issue_type">Issue Type:</label>
        <select name="issue_type">
            <option>OS Support</option>
            <option>Printer Support</option>
            <option>Network</option>
        </select>

        <label for="priority">Priority:</label>
        <select name="priority" required>
            <option value="" disabled selected>-- Select Priority --</option>
            <option>High</option>
            <option>Medium</option>
            <option>Low</option>
        </select>

        <label for="message">Message:</label>
        <textarea name="message" rows="5" cols="30"></textarea>

        <input type="submit" value="Submit Ticket">
    </form>
</div>

<!-- Botpress Webchat (optional) -->
<script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/06/03/04/20250603040323-KED2C522.js"></script>

</body>
</html>
