<?php
session_start();

function isValidQuantity($value) {
    return is_numeric($value) && intval($value) > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
    $quantities = $_POST['quantities'];
    $touched = [];
    $isInvalid = false;
    foreach ($quantities as $productId => $qty) {
        $qty = trim($qty);

        if($qty == 0){
            continue;
        }
        if (!isValidQuantity($qty)) {
            $isInvalid = true;
        } 

        $touched[intval($productId)] = $qty;
    }

    if ($isInvalid) {
        $_SESSION['form_error'] = "Перевірте будь ласка введені дані";
        $_SESSION['form_data'] = $touched;
        header("Location: ../products.php");
        exit();
    }

    foreach ($touched as $id => $value) {
        if ($value > 0) {
            $_SESSION['cart'][$id] = $value;
        } 
    }

    unset($_SESSION['form_error'], $_SESSION['form_data']);
    header("Location: ../cart.php");
    exit();
} else {
    echo "Неправильні дані.";
}
