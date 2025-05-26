<?php
include_once("./scripts/cart.php");
?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php?page=unauth");
    exit;
}
?>

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
        <button type="submit" name="action" value="pay">Оплатити</button>
        <button type="submit" name="action" value="cancel">Скасувати</button>
    </form>
<?php else: ?>
    <p>Кошик порожній. <a href="./index.php?page=products">Перейти до покупок</a></p>
<?php endif; ?>