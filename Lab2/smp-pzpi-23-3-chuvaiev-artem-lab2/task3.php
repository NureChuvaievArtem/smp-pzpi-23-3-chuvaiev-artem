#!/usr/bin/env php

<?php
class Item
{
    public $id;
    public $name;
    public $price;

    public function __construct($id, $name, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }
}

class Program
{
    private $items = [];
    private $user_name;
    private $user_age;

    public function __construct()
    {
        $jsonData = file_get_contents('items.json');
        $data = json_decode($jsonData, true);

        foreach ($data['Items'] as $id => $itemData) {
            $this->items[] = new Item($id, $itemData['name'], $itemData['price']);
        }
    }

    private function printMenu(): void
    {
        echo ("################################\n");
        echo ("# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n");
        echo ("################################\n");
        echo ("1 Вибрати товари\n");
        echo ("2 Отримати підсумковий рахунок\n");
        echo ("3 Налаштувати свій профіль\n");
        echo ("0 Вийти з програми\n");
    }

    private function getStringLength($str)
    {
        $chars = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
        return count($chars);
    }

    private function getLongestString(array $items): int
    {
        $longest = 0;
        foreach ($items as $value) {
            $currlen = $this->getStringLength($value->name);
            if ($longest < $currlen) { 
                $longest = $currlen;
            }
        }
        return $longest;
    }

    private function printItems(): void
    {
        $longest = $this->getLongestString($this->items);
        echo "№  НАЗВА" . str_repeat(" ", $longest - 5) . "  ";
        echo "ЦІНА\n";
        for ($i = 0; $i < count($this->items); $i += 1) {
            echo $this->items[$i]->id . "  ";
            echo $this->items[$i]->name . str_repeat(" ", $longest - $this->getStringLength($this->items[$i]->name)). "  ";
            echo $this->items[$i]->price . "\n";
        }
        echo ("-----------------\n");
        echo ("0  ПОВЕРНУТИСЯ\n");
    }

    private function displayCart(array $cart): void
    {
        $longest = $this->getLongestString($this->items);
        echo ("У КОШИКУ:\n");
        echo "НАЗВА" . str_repeat(" ", $longest - 5) . "  ";
        echo("КІЛЬКІСТЬ\n");
        for ($i = 0; $i < count($this->items); $i++) {
            if ($cart[$i] > 0) {
                echo $this->items[$i]->name . str_repeat(" ", $longest - $this->getStringLength($this->items[$i]->name)) . "  ";
                echo $cart[$i] . "\n";
                echo "\n";
            }
        }
    }

    public function main()
    {
        $cart = array_fill(0, count($this->items), 0);
        $selected = -1;

        while (true) {
            $this->printMenu();
            $selected = readline("Введіть команду: ");
            switch ($selected) {
                case 1:
                    while (1) {
                        $this->printItems();
                        $selectedItem = readline("Виберіть товар: ");
                        if ($selectedItem == 0) {
                            break;
                        }

                        if ($selectedItem < 0 || $selectedItem > count($this->items)) {
                            echo ("ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n");
                            continue;
                        }
                        $selectedAmount = readline("Введіть кількість, штук: ");
                        if ($selectedAmount < 0 || $selectedAmount > 100) {
                            echo ("ПОМИЛКА! Невірна кількість\n");
                            continue;
                        }
                        if ($selectedAmount == 0) {
                            if ($cart[$selectedItem - 1] > 0) {
                                echo ("ВИДАЛЯЮ З КОШИКА\n");
                                $cart[$selectedItem - 1] = 0;
                            }

                            $isEmpty = true;
                            foreach ($cart as $value) {
                                if ($value > 0) {
                                    $isEmpty = false;
                                    break;
                                }
                            }
                            if ($isEmpty) {
                                echo ("КОШИК ПОРОЖНІЙ\n");
                            }
                        } else {
                            $cart[$selectedItem - 1] = $selectedAmount;
                            $this->displayCart($cart);
                        }
                    }
                    break;
                case 2:
                    $total = 0;
                    $longest = $this->getLongestString($this->items);
                    echo "№  НАЗВА" . str_repeat(" ", $longest - 5) . "  ";
                    echo "ЦІНА  КІЛЬКІСТЬ  ВАРТІСТЬ\n";
                    $num = 1;
                    for ($i = 0; $i < count($this->items); $i++) {
                        if ($cart[$i] > 0) {
                            $cost = $cart[$i] * $this->items[$i]->price;
                            echo $num . "  ";
                            echo $this->items[$i]->name . str_repeat(" ", $longest - $this->getStringLength($this->items[$i]->name)) . "  ";
                            echo $this->items[$i]->price . str_repeat(" ", 4 - $this->getStringLength($this->items[$i]->price)) . "  ";
                            echo $cart[$i] . str_repeat(" ", 9 - $this->getStringLength($cart[$i])) . "  ";
                            echo $cost . "\n";
                            $total += $cost;

                            $num++;
                        }
                    }
                    echo ("РАЗОМ ДО CПЛАТИ: $total\n");
                    echo "\n";
                    break;
                case 3:
                    while (true) {
                        $name = readline("Ваше імʼя: ");
                        if (!preg_match('/\p{L}/u', $name)) {
                            echo ("Імʼя користувача не може бути порожнім і повинно містити хоча б одну літеру.\n");
                            continue;
                        }
                        $this->user_name = $name;
                        break;
                    }

                    while (true) {
                        $age = readline("Ваш вік: ");
                        if ($age < 7 || $age > 150) {
                            echo ("Користувач не може бути молодшим 7-ми або старшим 150-ти років\n");
                            continue;
                        }
                        $this->user_age = $age;
                        break;
                    }
                    echo ("Профіль встановлено: {$this->user_name}, {$this->user_age} років\n");
                    echo "\n";
                    break;
                case 0:
                    echo ("До побачення!\n");
                    return 0;
                default:
                    echo ("ПОМИЛКА! Введіть правильну команду\n");
            }
        }
    }
}

$program = new Program();
$program->main();
?>