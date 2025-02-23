<?php

session_start();

function checkSession() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/index.php");
        exit();
    }
}

function checkRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: ../public/index.php");
        exit();
    }
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: ../public/index.php");
    exit();
}