<?php include 'db.php'; ?>

diya_bhat
<?php
// Ticket status counts with proper capitalization
$counts = [
    'Open' => 0,
    'In Progress' => 0,
    'Closed' => 0
];

$result = $conn->query("SELECT status, COUNT(*) as count FROM tickets GROUP BY status");
while ($row = $result->fetch_assoc()) {
    $status = $row['status'];
    if (array_key_exists($status, $counts)) {
        $counts[$status] = $row['count'];
    }

<h2>Admin - View Tickets</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Issue</th><th>message</th><th>Priority</th><th>Status</th><th>Created</th><th>Action</th><th>Delete</th>
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
        <td>{$row['status']}</td>
        <td>{$row['created_at']}</td>
        <td><a href='view_ticket.php?id={$row['id']}'>View</a></td>
        <td><a href='delete_ticket.php?id={$row['id']}'>Delete</a></td>
    </tr>";
main
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .status-boxes {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px auto 0;
        }

        .status-box {
            padding: 20px 30px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-size: 22px;
            font-weight: bold;
            color: #444;
            min-width: 150px;
        }

        .open { border-left: 8px solid rgb(242, 141, 47); }
        .progress { border-left: 8px solid rgb(54, 160, 235); }
        .closed { border-left: 8px solid rgb(53, 179, 27); }

        .chart-container {
            width: 500px;
            margin: 40px auto;
        }

        table {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
        }

        table th {
            background: #333;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Admin Dashboard</h1>

    <div class="status-boxes">
        <div class="status-box open">Open: <?= $counts['Open'] ?></div>
        <div class="status-box progress">In Progress: <?= $counts['In Progress'] ?></div>
        <div class="status-box closed">Closed: <?= $counts['Closed'] ?></div>
    </div>

    <h2>All Tickets</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th><th>Name</th><th>Issue</th><th>Priority</th><th>Status</th><th>Created</th><th>Action</th><th>Delete</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM tickets ORDER BY FIELD(Priority, 'High', 'Medium', 'Low'), created_at DESC");
        while($row = $result->fetch_assoc()) {
            echo "<tr data-status='{$row['status']}'>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['issue_type']}</td>
                <td>{$row['Priority']}</td>
                <td>{$row['status']}</td>
                <td>{$row['created_at']}</td>
                <td><a href='view_ticket.php?id={$row['id']}'>View</a></td>
                <td><a href='delete_ticket.php?id={$row['id']}'>Delete</a></td>
            </tr>";
        }
        ?>
    </table>

    <p style="text-align:center;">
        <button onclick="showAllTickets()">Show All Tickets</button>
    </p>

    <p style="text-align:center;"><a href='index.php'>Add another ticket</a></p>

    <div class="chart-container">
        <canvas id="ticketChart"></canvas>
    </div>

    <script>
        function showAllTickets() {
            const rows = document.querySelectorAll('table tr[data-status]');
            rows.forEach(row => row.style.display = '');
        }

        const ctx = document.getElementById('ticketChart').getContext('2d');
        const ticketChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Open', 'In Progress', 'Closed'],
                datasets: [{
                    label: 'Ticket Count',
                    data: [<?= $counts['Open'] ?>, <?= $counts['In Progress'] ?>, <?= $counts['Closed'] ?>],
                    backgroundColor: [
                        'rgb(242, 141, 47)',
                        'rgb(54, 160, 235)',
                        'rgb(53, 179, 27)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                onClick: function(evt, elements) {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const selectedLabel = this.data.labels[index];

                        const rows = document.querySelectorAll('table tr[data-status]');
                        rows.forEach(row => {
                            if (row.getAttribute('data-status') === selectedLabel) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Ticket Status Distribution'
                    }
                }
            }
        });
    </script>

</body>
</html>
