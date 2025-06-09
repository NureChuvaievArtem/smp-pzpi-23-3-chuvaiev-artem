<?php
if(!isset($_SESSION['username'])){
    header("Location: ../index.php?page=unauth");
}
?>

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
                    min="-10"
                    class="product-qty">
                <span class="product-price">$<?= number_format($product->price, 2) ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <button type="submit" class="submit-button">Додати до кошика</button>
</form>
<?php
unset($_SESSION['form_error'], $_SESSION['form_data']);
?>