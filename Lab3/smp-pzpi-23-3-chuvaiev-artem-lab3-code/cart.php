<?php
include_once("./scripts/init.php");
include_once("./scripts/cart.php");
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Кошик</title>
</head>

<body>
    <?php include("./layout/header.php"); ?>
    <div class="content">
        <h2>Кошик</h2>

        <?php if (isNotEmpty()): ?>
            <table cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Ціна</th>
                        <th>Кількість</th>
                        <th>Сума</th>
                        <th>Дія</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach (getCart() as $id => $quantity):
                        if ($quantity > 0 && isset($program->items[$id])):
                            $item = $program->items[$id];
                            $sum = $item->price * $quantity;
                            $total += $sum;
                    ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= htmlspecialchars($item->name) ?></td>
                                <td>$<?= number_format($item->price, 2) ?></td>
                                <td><?= $quantity ?></td>
                                <td>$<?= number_format($sum, 2) ?></td>
                                <td>
                                    <form method="POST" action="./scripts/deleteFromCart.php" style="display:inline;">
                                        <input type="hidden" name="remove_id" value="<?= $id ?>">
                                        <button type="submit">Видалити</button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                    <tr>
                        <td colspan="4" style="text-align:right; font-weight:bold;">Всього:</td>
                        <td colspan="2" style="font-weight:bold;">$<?= number_format($total, 2) ?></td>
                    </tr>
                </tbody>
            </table>
            <form method="POST" action="./scripts/clearCart.php" style="margin-top: 20px;">
                <button type="submit" name="action" value="cancel">Скасувати</button>
                <button type="submit" name="action" value="pay">Оплатити</button>
            </form>
        <?php else: ?>
            <p>Кошик порожній. <a href="./products.php">Перейти до покупок</a></p>
        <?php endif; ?>
    </div>
    <?php include("./layout/footer.php"); ?>
</body>

</html>