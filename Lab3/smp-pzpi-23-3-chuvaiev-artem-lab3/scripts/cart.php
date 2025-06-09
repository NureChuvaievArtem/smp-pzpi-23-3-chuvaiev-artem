<?php
function getCart()
{
    if (isset($_SESSION['cart'])) {
        return $_SESSION['cart'];
    }
}

function isNotEmpty()
{
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $item) {
            if ($item != 0) {
                return true;
            }
        }
        return false;
    }
}
