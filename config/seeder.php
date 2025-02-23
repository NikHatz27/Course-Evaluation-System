<?php

require 'DB_connection.php';

function generateRandomString($length = 10) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}


try {
    
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for ($i = 0; $i < 10; $i++) {
        $name = generateRandomString();
        $plainPassword = generateRandomString();
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'student')");
        $stmt->bindParam(':username', $name);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        echo "Inserted: Name = $name, Plain Password = $plainPassword <br>";
    }

    echo "<br> Data inserted successfully.";
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo "An error occurred. Please check the logs.";
}