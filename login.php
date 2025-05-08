<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['first_name'] . " " . $user['last_name'];
            $_SESSION['user_email'] = $user['email']; // ✅ Fixing session variable

            echo "✅ Login Successful.  Redirecting to Homepage...";
          //  sleep(1);
            echo "<script>
        setTimeout(function() {
            window.location.href = 'web.html';
        }, 3000);
      </script>";
            exit();
        } else {
            echo "Invalid email or password. <a href='login.html'>Try again</a>";
        }
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
} else {
    echo "❌ Invalid request method.";
}
?>



