<?php

require_once '../config/DB_connection.php';
require_once '../authentication/session.php';

checkSession();
checkRole('student');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logout();
}

$user_id = $_SESSION['user_id'] ?? null; 


if (!isset($_SESSION['username']) && $user_id) {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['username'] = $user['username']; 
    }
}                   


$username = $_SESSION['username'] ?? 'Student';


$stmt = $pdo->query("SELECT id, name FROM courses");
$courses = $stmt->fetchAll();


$stmt = $pdo->prepare("SELECT course_id FROM ratings WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$ratedCourses = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../assets/student_style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>

        <form action="" method="POST" style="display: inline;">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>

        <h2>Available Courses</h2>
        <div class="course-list">
            <?php if (empty($courses)): ?>
                <p>No courses available.</p>
            <?php else: ?>
                <?php foreach ($courses as $course): ?>
                    <div class="course-item">
                        <span><?= htmlspecialchars($course['name']) ?></span>

                        <?php if (in_array($course['id'], $ratedCourses)): ?>
                            <p class="rated-text">You have already rated this course.</p>
                        <?php else: ?>
                            
                            <form action="student_processes/rate_course.php" method="POST" style="display:inline;">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <label for="rating">Rate:</label>
                                <select name="rating" required>
                                    <option value="1">⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                </select>
                                <button type="submit">Submit</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
