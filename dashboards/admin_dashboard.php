<?php
require_once '../config/DB_connection.php';
require_once '../authentication/session.php';
checkSession();
checkRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logout(); 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../assets/admin_style.css">
    
</head>
<body>
    <div class="container">
    
        <form action="" method="POST" style="display: inline;">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>

        <h1>Admin Dashboard</h1>

    
        <form action="admin_processes/insert.php" method="POST">
            <div class="form-group">
                <label for="name">Course Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <button type="submit">Add Course</button>
        </form>

    
        <div class="course-list">
            <h2>Existing Courses</h2>
            <?php
    
            $stmt = $pdo->query("
                SELECT c.id, c.name, AVG(r.rating) AS average_rating
                FROM courses c
                LEFT JOIN ratings r ON c.id = r.course_id
                GROUP BY c.id
            ");
            $courses = $stmt->fetchAll();

            if (empty($courses)) {
                echo "<p class='no-courses'>No courses found.</p>";
            } else {
                foreach ($courses as $course) {
                    $averageRating = $course['average_rating'] ? round($course['average_rating'], 1) : 'No ratings yet';
                    echo "<div class='course-item'>
                            <span>{$course['name']} <strong>(Rating: {$averageRating})</strong></span>
                            <form action='admin_processes/delete.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$course['id']}'>
                                <button type='submit'>Delete</button>
                            </form>
                          </div>";
                }
            }
            ?>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> CourseR8. All rights reserved.</p>
</body>
</html>