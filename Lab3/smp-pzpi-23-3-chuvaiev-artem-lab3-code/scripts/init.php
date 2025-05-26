<?php
include_once("./classes/entities.php");
$program = new Program();

if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    
        foreach ($program->items as $id => $item) {
            $_SESSION['cart'][$id] = 0;
        }
    }
}
?>