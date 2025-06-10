<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $conn->query("UPDATE tickets SET status='$status' WHERE id=$id");
}

$ticket = $conn->query("SELECT * FROM tickets WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Ticket</title>
    <style>
        .view-tickets-heading {
            font-family: 'Segoe UI', sans-serif;
            font-size: 32px;
            color: rgb(19, 20, 20);
            text-align: center;
            margin-top: 30px;
            letter-spacing: 1px;
            font-weight: 600;
            border-bottom: 2px solid #2980b9;
            display: inline-block;
            padding-bottom: 10px;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .ticket-box {
            background: black;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            margin-top: 20px;
        }

        h2 {
            margin-top: 0;
            color: white;
        }

        p {
            text-align: left;
            margin: 10px 0;
        }

        select, input[type="submit"] {
            margin-top: 10px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #0066cc;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Heading ABOVE the ticket box -->
    <h1 class="view-tickets-heading">View Tickets</h1>

    <div class="ticket-box">
        <h2>Ticket #<?= $ticket['id'] ?></h2>
        <p><strong>Name:</strong> <?= $ticket['name'] ?></p>
        <p><strong>Email:</strong> <?= $ticket['email'] ?></p>
        <p><strong>Issue:</strong> <?= $ticket['issue_type'] ?></p>
        <p><strong>Priority:</strong> <?= $ticket['priority'] ?></p>
        <p><strong>Message:</strong> <?= nl2br($ticket['message']) ?></p>
        <p><strong>Status:</strong> <?= $ticket['status'] ?></p>

        <form method="post">
            <label>Update Status:</label>
            <select name="status">
                <option <?= $ticket['status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                <option <?= $ticket['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option <?= $ticket['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
            </select>
            <input type="submit" value="Update">
        </form>

        <a href="admin.php">← Back to Dashboard</a>
    </div>

</body>
</html>
