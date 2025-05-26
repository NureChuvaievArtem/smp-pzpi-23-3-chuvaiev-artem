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

    public function __construct()
    {
        $jsonData = file_get_contents('items.json');
        $data = json_decode($jsonData, true);

        foreach ($data['Items'] as $id => $itemData) {
            $this->items[] = new Item($id, $itemData['name'], $itemData['price']);
        }
    }
}

?>