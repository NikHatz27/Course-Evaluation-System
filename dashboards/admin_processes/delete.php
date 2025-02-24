<?php
require_once '../../config/DB_connection.php';
require_once '../../authentication/session.php';

checkSession();
checkRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (!empty($id)) {
        try {
            
            $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
            $stmt->execute(['id' => $id]);

           
            header("Location: ../admin_dashboard.php");
            exit();
        } catch (PDOException $e) {
            die("Error deleting course: " . $e->getMessage());
        }
    } else {
        die("Course ID cannot be empty.");
    }
} else {
    die("Invalid request method.");
}
?>