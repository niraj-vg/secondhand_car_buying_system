<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*
// Debugging: Print all received POST data
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit; // Stop execution to inspect the output
*/
// Database connection details
define("DB_HOST", "localhost");
define("DB_NAME", "car");
define("DB_USER", "postgres");
define("DB_PASS", "123");

// Connect to PostgreSQL
$conn = pg_connect("host=" . DB_HOST . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASS);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Check if form is submitted
// Ensure REQUEST_METHOD is set before accessing it
// Ensure REQUEST_METHOD is set before accessing it
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $email = $_POST['email'] ?? '';
    $car_name = $_POST['car_name'] ?? '';
    $delivery_date = $_POST['delivery_date'] ?? '';

    // Validate delivery date
    if (empty($delivery_date)) {
        echo "Error: Delivery date is required.";
        exit;
    }
    
    /*if (empty($car_name)) {
    die("Error: Car name is missing from the POST request.");
    }
    */
    // Insert data into the database
    $query = "INSERT INTO car_purchases (name, password, mobile, email, car_name, delivery_date) 
              VALUES ($1, $2, $3, $4, $5, $6)";
    
    $result = pg_query_params($conn, $query, array($name, $password, $mobile, $email, $car_name, $delivery_date));

    if ($result) {
        echo "Purchase successful!";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}


// Close connection
pg_close($conn);
?>
