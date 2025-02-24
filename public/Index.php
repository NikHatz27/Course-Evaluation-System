<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseR8</title>
    <link rel="stylesheet" type="text/css" href="../assets/index_styles.css">


</head>
<body>
    <main>
    <img src="../assets/images/logo.png" alt="CourseR8 Logo">  
    <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); 
        }
    ?>
    <form action="../authentication/login_process.php" method = "post">
    <label for="username">Username:</label>
    <input type="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
    </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> CourseR8. All rights reserved.</p>
</body>
</html>