<?php
    include_once("../credentials.php"); 
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])){
        if($credentials['username'] != $_POST['username'] || $credentials['password'] != $_POST['password'])
        {
            header("Location: ../index.php?page=login");
            exit();
        }
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['authorized_at'] = time();

        header("Location: ../index.php?page=profile");
        exit();
    }
?>