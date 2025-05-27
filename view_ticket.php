<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $conn->query("UPDATE tickets SET status='$status' WHERE id=$id");
}

$ticket = $conn->query("SELECT * FROM tickets WHERE id=$id")->fetch_assoc();
?>

<h2>Ticket #<?= $ticket['id'] ?></h2>
<p><strong>Name:</strong> <?= $ticket['name'] ?></p>
<p><strong>Email:</strong> <?= $ticket['email'] ?></p>
<p><strong>Issue:</strong> <?= $ticket['issue_type'] ?></p>
<p><strong>Priority:</strong> <?=$ticket['Priority'] ?></p>
<p><strong>Message:</strong> <?= nl2br($ticket['message']) ?></p>
<p><strong>Status:</strong> <?= $ticket['status'] ?></p>

<form method="post">
    Update Status:
    <select name="status">
        <option>Open</option>
        <option>In Progress</option>
        <option>Closed</option>
    </select>
    <input type="submit" value="Update">
</form>

<p><a href="admin.php">Back to Dashboard</a></p>