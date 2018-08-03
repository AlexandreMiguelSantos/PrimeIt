<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Santos
 * Date: 02/08/2018
 * Time: 15:25
 */

class Customer
{

    private $id;

    private $name;

    private $since;

    private $revenue;

    private $error;

    private $discount;

    private $customers;

    public function __construct($customerId)
    {
        $this->setCustomer($customerId);
    }

    public function setCustomer($customerId)
    {
        $this->customers = json_decode(file_get_contents('../Json/Customer/customers.json'), true);
        foreach ($this->customers as $costumer)
        {
            if ($customerId == $costumer['id'])
            {
                $this->id       = $costumer['id'];
                $this->name     = $costumer['name'];
                $this->since    = $costumer['since'];
                $this->revenue  = $costumer['revenue'];
            }
            else $this->error = 1;
        }
        $this->verifyCustomer();
    }

    public function verifyCustomer()
    {
        if (empty($this->id))
            $this->error = 1;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSince()
    {
        return $this->since;
    }

    public function getRevenue()
    {
        return $this->revenue;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setDiscount($value)
    {
        $this->discount = $value;
    }
    public function getDiscount()
    {
        return $this->discount;
    }
}
