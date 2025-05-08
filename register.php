<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

   
    if ($password !== $confirm_password) {
        die("❌ Passwords do not match. <a href='register.html'>Try again</a>");
    }

    
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $hashed_password 
        ]);
        echo "✅ Registration successful! <a href='login.html'>Login here</a>";
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage(); 
    }
} else {
    echo "❌ Invalid request method.";
}
?>
