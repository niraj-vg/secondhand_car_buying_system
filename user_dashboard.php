<?php
session_start();
include 'db_connect.php';

// ✅ Fix: Checking both session variables
if (!isset($_SESSION['user_email']) && !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user_email'];

try {
    $query = "SELECT id, car_name, delivery_date, status FROM car_purchases WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
    $stmt->execute();
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        /* 🔹 Navigation Bar */
        .navbar {
            background: #007bff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        .navbar .logo {
            font-size: 22px;
            font-weight: bold;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }
        .navbar .logout {
            background: #ff4d4d;
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .navbar .logout:hover {
            background: #cc0000;
        }

        /* 🔹 Dashboard Container */
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 50%;
            margin: 100px auto;
        }
        h2 {
            color: #333;
        }
        h3 {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background: #007bff;
            color: #fff;
        }
        td {
            background: #f9f9f9;
        }
        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .pending {
            color: red;
            background: #ffd1d1;
        }
        .approved {
            color: green;
            background: #d1ffd1;
        }
        a.button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border-radius: 5px;
            transition: 0.3s;
        }
        a.button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>User Dashboard</h2>
    <h3>My Car Purchases</h3>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Car Name</th>
            <th>Delivery Date</th>
            <th>Status</th>
        </tr>

        <?php if (!empty($purchases)) : ?>
            <?php foreach ($purchases as $row) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['car_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['delivery_date']); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">No purchases found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <br>
    <a href="web.html">GO TO HOMEPAGE</a>
    <a href="logout.php">Logout</a>
</body>
</html>
