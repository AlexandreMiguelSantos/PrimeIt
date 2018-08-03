<?php
/**
 * For each discount add a new method and create a type
 * Also can be set to a db with a table off discounts
 * to set the values of the discounts parameters and bonus
 */

class Discount
{
    private $customerRevenueAmount = 1000;

    private $customerRevenueDiscount = .1;

    private $products;

    private $categoryTypeQuantityDiscount = 2;

    private $categoryTypeMinQuantityDiscount = 5;

    private $categoryQuantityDiscount = 1;

    private $discountType2CategoryType = 1;

    private $discountType2ProductCount = 0;

    private $discountType2ProductMin = 2;

    private $discountType2value = .2;

    private $productIdMinPrice;

    public function discountType($type, $data)
    {
        if ($type == "customer")
           return $this->discountCustomer($data->getRevenue());

        if ($type == "product")
            return $this->discountProduct($data);
    }

    /**
     * sets the discount for:
     * A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
     * @param $value
     * @return float
     */
    public function discountCustomer($value)
    {
        if ($value>=$this->customerRevenueAmount)
            return $this->customerRevenueDiscount;
    }

    /**
     * Sets the varios types of discount for the product
     * @param $products
     * @return mixed
     */
    public function discountProduct($products)
    {
        $this->products = $products;

        $this->discountType1();
        $this->discountType2();
        return $this->products;
    }

    /**
     * sets the discount for:
     * For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
     */
    public function discountType1()
    {
        foreach($this->products as $product){
            if ($product->getCategory() == $this->categoryTypeQuantityDiscount)
                if($product->getQuantity() >= $this->categoryTypeMinQuantityDiscount)
                    $product->setQuantity($product->getQuantity()+$this->categoryQuantityDiscount);
        }
    }

    /**
     * sets the discount for:
     * If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product
     */
    public function discountType2()
    {
        foreach($this->products as $product){
            if ($product->getCategory() == $this->discountType2CategoryType)
            {
                if(empty($this->productIdMinPrice))
                {
                    $this->productIdMinPrice['id'] = $product->getId();
                    $this->productIdMinPrice['price'] = $product->getPrice();
                }

                $this->discountType2ProductCount++;

                if ($this->discountType2ProductCount >= $this->discountType2ProductMin)
                {
                    if ($product->getPrice()< $this->productIdMinPrice['price'])
                    {
                        $this->productIdMinPrice['id'] = $product->getId();
                        $this->productIdMinPrice['price'] = $product->getPrice();
                    }
                }

            }
        }

        if ($this->discountType2ProductCount >= $this->discountType2ProductMin)
            foreach($this->products as $product)
            {
                if ($product->getId() == $this->productIdMinPrice['id'])
                    $product->setDiscount($this->discountType2value);
            }

    }
}