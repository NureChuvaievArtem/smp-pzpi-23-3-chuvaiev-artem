<?php
include_once("./classes/entities.php");

$database->execute("
    create table if not exists products (
        id integer primary key autoincrement, name text not null, price integer not null
    )
");

$result = $database->fetchOne("select count(*) as count from products");
$count = (int) $result['count'];

if ($count == 0) {
    $database->execute("
        insert into products (name, price) values
        ('Молоко пастеризоване', 12),
        ('Хліб чорний', 9),
        ('Сир білий', 21),
        ('Сметана 20%', 25),
        ('Кефір 1%', 19),
        ('Вода газована', 25),
        ('Печиво \"Весна\"', 25);
    ");
}

$program = new Program($database);

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