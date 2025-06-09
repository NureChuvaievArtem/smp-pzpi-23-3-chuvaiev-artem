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
    public $items = [];

    public function __construct($database)
    {
        $data = $database->fetchAll("SELECT * FROM PRODUCTS");

        foreach ($data as $itemData) {
            $this->items[] = new Item($itemData['id'], $itemData['name'], $itemData['price']);
        }
    }
}

?>