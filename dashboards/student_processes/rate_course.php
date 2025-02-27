<?php
require_once '../../config/DB_connection.php';
require_once '../../authentication/session.php';

checkSession();
checkRole('student');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id']; 

    if (!empty($course_id) && !empty($rating) && $rating >= 1 && $rating <= 5) {
        try {
            
            $stmt = $pdo->prepare("SELECT id FROM ratings WHERE user_id = :user_id AND course_id = :course_id");
            $stmt->execute(['user_id' => $user_id, 'course_id' => $course_id]);
            $existingRating = $stmt->fetch();

            if ($existingRating) {
                
                die("You have already rated this course.");
            } else {
                
                $stmt = $pdo->prepare("INSERT INTO ratings (user_id, course_id, rating) VALUES (:user_id, :course_id, :rating)");
                $stmt->execute(['user_id' => $user_id, 'course_id' => $course_id, 'rating' => $rating]);

                header("Location: ../student_dashboard.php");
                exit();
            }
        } catch (PDOException $e) {
            die("Error submitting rating: " . $e->getMessage());
        }
    } else {
        die("Invalid rating input.");
    }
} else {
    die("Invalid request method.");
}
