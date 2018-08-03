<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Santos
 * Date: 02/08/2018
 * Time: 16:32
 */

class Product
{

    public $id;

    public $description;

    public $category;

    public $price;

    public $quantity;

    public $discount;

    public $total;

    public $products;

    public $error = 0;


    public function __construct($item)
    {
        $this->getProductsFromFile();
        $this->setProduct($item);
    }

    public function getProductsFromFile()
    {
        $this->products = json_decode(file_get_contents('../Json/Products/products.json'), true);
    }

    public function setProduct($item)
    {
        foreach($this->products as $product)
        {
            if ($product['id']== $item['product-id'])
            {
                $this->id = $product['id'];
                $this->description = $product['description'];
                $this->category = $product['category'];
                $this->price = $product['price'];
                $this->quantity = $item['quantity'];
                $this->setTotal();
            }
            else $this->error = 1;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;
        $this->setTotal();
    }
    public function getDiscount()
    {
        return $this->discount*100;
    }

    private function setTotal()
    {
        $this->total = $this->price * $this->quantity * (1-$this->discount);
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getError()
    {
        return $this->Error;
    }
}
