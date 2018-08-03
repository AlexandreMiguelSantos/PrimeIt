<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Santos
 * Date: 02/08/2018
 * Time: 11:26
 */

include "Controller/Request.php";

$requestOrder = new Request($_GET['order']);
// Just to see the response
echo $requestOrder->response();
