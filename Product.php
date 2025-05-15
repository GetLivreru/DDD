<?php

class Product {
    public $id;
    public $name;
    public $code;

    public function __construct($id, $name, $code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }
}

/*class ProductMapper{
    public static function map(array $data):  Product{
        $product = new Product();
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        return $product;
    }
}*/

class Input{

}
class Output{

}
