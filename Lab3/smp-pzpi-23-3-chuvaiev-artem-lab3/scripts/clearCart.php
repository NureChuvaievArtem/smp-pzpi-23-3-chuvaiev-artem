<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && ($_POST['action'] === 'pay' || $_POST['action'] === 'cancel')) {
        unset($_SESSION['cart']);
    }
}

header("Location: ../cart.php"); 
exit;