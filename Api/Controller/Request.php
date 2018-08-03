<?php

/**
 * This class is to treat with all types of request.
 * Other types may be added by add new method's.
 * we are using a request from a json file that are provide for the cliente.
 * it must be changed at the line 38 to work with other types like get, post.
 */

include './Entity/Customer.php';
include './Entity/Product.php';
include './Entity/Order.php';
include './Entity/Discount.php';

class Request
{

    private $order;

    private $errorCode = array(
        0 => 'Empty request.',
    );

    private $orderProcess;

    public $response;

    public function __construct($orderData=null)
    {
        (!empty($orderData)) ? $this->verifyOrder($orderData): $this->response['error'] = $this->errorCode['0'];
    }

    /**
     * @param $orderData
     */
    private function verifyOrder($orderData)
    {
        $this->order = json_decode(file_get_contents('../Json/Order/order'.$orderData.'.json'), true);

        (!empty($orderData)) ? $this->setOrder(): $this->response = $this->errorCode['1'];
    }

    /**
     * Sets the order and recieve the answer
     */
    private function setOrder()
    {
        $this->orderProcess = new Order($this->order);
        $this->response =  $this->orderProcess->getResponse();
    }

    /**Send's the varios responses
     * @return string
     */
    public function response()
    {
        return json_encode($this->response);
    }

}
