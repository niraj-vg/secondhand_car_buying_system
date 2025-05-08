<?php
session_start();
include 'db_connect.php'; // Ensure database connection via PDO

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $purchase_id = $_POST['id'];

    try {
        // ✅ Update the status to 'approved'
        $query = "UPDATE car_purchases SET status = 'approved' WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $purchase_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "✅ Status updated to APPROVED!";
            sleep(1);
            echo "<script>
        setTimeout(function() {
            window.location.href = 'admin_dashboard.php';
        }, 2000);
      </script>";
            exit();
        } else {
            echo "❌ Error: No rows updated! Check if ID exists.";
        }
    } catch (PDOException $e) {
        die("❌ Error updating status: " . $e->getMessage());
    }
} else {
    echo "❌ Invalid request!";
}
?>


