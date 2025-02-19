<?php
function goBack() {
    if (!empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== $_SERVER['REQUEST_URI']) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Default fallback in case HTTP_REFERER is not set or looping
        header("Location: index.php");
        exit();
    }
}


goBack();
?>