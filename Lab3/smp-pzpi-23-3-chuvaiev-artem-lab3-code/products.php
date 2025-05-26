<?php
include_once("./scripts/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/products.css">
    <title>Продукти</title>
</head>

<body>
    <?php
    include("./layout/header.php")
    ?>
    <div class="content">
        <form method="POST" action="./scripts/addToCart.php" class="product-form">
            <?php if (isset($_SESSION['form_error'])): ?>
                <p style="color: red;"><?= $_SESSION['form_error'] ?></p>

                <?php foreach ($_SESSION['form_data'] as $id => $badValue): ?>
                    <?php if (isset($program->items[$id])): ?>
                        <div class="product-row">
                            <span class="product-name"><?= htmlspecialchars($program->items[$id]->name) ?></span>
                            <input type="number"
                                name="quantities[<?= $id ?>]"
                                value="<?= htmlspecialchars($badValue) ?>"
                                min="-10"
                                class="product-qty">
                            <span class="product-price">$<?= number_format($program->items[$id]->price, 2) ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            <?php else: ?>
                <?php foreach ($program->items as $id => $product): ?>
                    <div class="product-row">
                        <span class="product-name"><?= htmlspecialchars($product->name) ?></span>
                        <input type="number"
                            name="quantities[<?= $id ?>]"
                            value="0"
                            class="product-qty">
                        <span class="product-price">$<?= number_format($product->price, 2) ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <button type="submit" class="submit-button">Додати до кошика</button>
        </form>
    </div>
    <?php
    include("./layout/footer.php")
    ?>

    <?php
    unset($_SESSION['form_error'], $_SESSION['form_data']);
    ?>
</body>

</html>