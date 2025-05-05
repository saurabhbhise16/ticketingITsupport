<?php include 'db.php'; ?>

<h2>Admin - View Tickets</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Name</th><th>Issue</th><th>Status</th><th>Created</th><th>Action</th>
    </tr>

<?php
$result = $conn->query("SELECT * FROM tickets ORDER BY created_at DESC");
while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['issue_type']}</td>
        <td>{$row['status']}</td>
        <td>{$row['created_at']}</td>
        <td><a href='view_ticket.php?id={$row['id']}'>View</a></td>
    </tr>";
}
?>
</table>
