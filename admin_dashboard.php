<?php
session_start();
include 'db_connect.php'; // Ensure this connects via PDO

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

try {
    // ✅ Fetch car purchases data securely using PDO
    $query = "SELECT id, name, mobile, email, car_name, delivery_date FROM car_purchases";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $car_purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2, h3 {
            text-align: center;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }

        .approve { background-color: green; }
        .reject { background-color: red; }
        .logout { background-color: #007bff; display: block; width: 150px; text-align: center; margin: 20px auto; }
        
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <h3>Car Purchases</h3>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Car Name</th>
            <th>Delivery Date</th>
            <th>Action</th>
        </tr>
        
        <?php foreach ($car_purchases as $row) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['car_name']); ?></td>
                <td><?php echo htmlspecialchars($row['delivery_date']); ?></td>
                <td>
                   
    <form action="approve.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button type="submit" class="btn approve">Approve</button>
    </form>

    <form action="reject.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button type="submit" class="btn reject">Reject</button>
    </form>
</td>

                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="logout.php" class="btn logout">Logout</a>
</body>
</html>
