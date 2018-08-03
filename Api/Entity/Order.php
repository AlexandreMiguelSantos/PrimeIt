<?php
/**
 * This Classe treat the all order and set the response.
 *
 */



class Order
{
    private $id;

    private $customer;

    private $products;

    private $error;

    private $errorCode = array(
        0 => 'No order id. This order can\'t be process',
        1 => 'Empty Order.',
        2 => 'Customer don\'t exist, Create the costumer.',
        3 => 'No items.',
        4 => 'Item no longer exist.'
    );

    private $totalValue;

    private $response;

    public function __construct($rawOrder)
    {
        if (!empty($rawOrder['id'])){
            $this->setId($rawOrder['id']);

            if (!empty($rawOrder["customer-id"]))
                $this->setCustomer($rawOrder["customer-id"]);
            else
                $this->error[2] = $this->errorCode[2];

            if (!empty($rawOrder["items"]))
                $this->setProducts($rawOrder["items"]);
            else
                $this->error[3] = $this->errorCode[3];

            $this->setDiscount();
        }
        else
            $this->error[0] = $this->errorCode[0];

        $this->setResponse();
    }

    /**
     * @param $orderId
     */
    public function setId($orderId)
    {
        $this->id = $orderId;
    }

    /**
     * Set the costumer class that gets is data from a Json.
     * This must be changed to the customer class
     */
    public function setCustomer($customerId)
    {
        $this->customer = new Customer($customerId);
    }

    /**
     * Set the Products class that gets is data from a Json.
     * This must be changed to the Products class
     */
    public function setProducts($items)
    {
        foreach ($items as $item)
            $this->products[] = new Product($item);
    }

    /**
     * Set the Discounts class
     * In case of more discounts needs to be updated
     */
    public function setDiscount()
    {
        $discount = new Discount();

        if(!$this->error[2])
            $this->customer->setDiscount($discount->discountType("customer", $this->customer ));
        $this->products =  $discount->discountType("product", $this->products );

    }

    /**
     * Preperes the response to the request class
     */
    public function setResponse()
    {
        if (empty($this->error))
        {
            $this->response['id'] = $this->id;
            $this->response['customer-id'] = $this->customer->getId();

            foreach($this->products as $product)
            {
                $item['product-id'] = $product->getId();
                $item['quantity']   = $product->getQuantity();
                $item['unit-price'] = $product->getPrice();
                $item['total']      = $product->getTotal();
                $this->totalValue   += $product->getTotal();
                $this->response['items'][] = $item;
            }

            $this->response['total'] = $this->totalValue;

            if ($this->customer->getDiscount())
                $this->response['total'] = $this->totalValue * (1-$this->customer->getDiscount()) ;
        }
        else
            $this->response['error'] = $this->error;

    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }


}