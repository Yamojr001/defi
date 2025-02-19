<?php

if (!isset($_SESSION['user_id']) ||!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    // Redirect to login page or show an error
    header('Location: ../login.php');
    exit();
}

?>