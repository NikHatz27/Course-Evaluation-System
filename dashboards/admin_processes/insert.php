<?php
require_once '../../config/DB_connection.php';
require_once '../../authentication/session.php';

checkSession();
checkRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    if (!empty($name)) {
        try {
           
            $stmt = $pdo->prepare("INSERT INTO courses (name) VALUES (:name)");
            $stmt->execute(['name' => $name]);

            
            header("Location: ../admin_dashboard.php");
            exit();
        } catch (PDOException $e) {
            die("Error inserting course: " . $e->getMessage());
        }
    } else {
        die("Course name cannot be empty.");
    }
} else {
    die("Invalid request method.");
}
?>