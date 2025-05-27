<?php include 'db.php'; ?>

<h2>Admin - View Tickets</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Issue</th><th>message</th><th>Priority</th><th>Created</th><th>Action</th><th>Delete</th>
    </tr>

<?php
$result = $conn->query("SELECT * FROM tickets ORDER BY field(Priority, 'High', 'Medium', 'Low'), created_at DESC");
while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['issue_type']}</td>
        <td>{$row['message']}</td>
        <td>{$row['priority']}</td>
        <td>{$row['created_at']}</td>
        <td><a href='view_ticket.php?id={$row['id']}'>View</a></td>
        <td><a href='delete_ticket.php?id={$row['id']}'>Delete</a></td>
    </tr>";
}
?>
</table>

<br><a href='index.php?id={$row['id']}'>Add another ticket</a></br>