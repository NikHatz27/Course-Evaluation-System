<?php
require_once 'session.php';
require_once '../config/DB_connection.php';

$conn = $pdo;

$username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
$password = trim($_POST['password'] ?? '');


if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username and password are required.";
    header("Location: ../public/index.php");
    exit();
}

try {

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['role'] = $user['role'];  

        if ($user['role'] === 'student') {
            header("Location: ../dashboards/student_dashboard.php");
        } else {
            header("Location: ../dashboards/admin_dashboard.php");
        }
        exit();
    }

    $_SESSION['error'] = "Invalid username or password.";
    header("Location: ../public/index.php");
    exit();
} catch (PDOException $e) {
    error_log("Login Error: " . $e->getMessage());
    $_SESSION['error'] = "Something went wrong. Please try again.";
    header("Location: ../public/index.php");
    exit();
}
?>
