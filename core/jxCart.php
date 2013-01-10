<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damien PICHEVIN
 * Date: 30/12/12
 * Time: 11:02
 *
 */

require_once 'coreCart.php';

class jxCart extends coreCart
{

    protected function addProduct($value)
    {
        $v = (object)$value;
        $this->addItem($v->idProduct, $v->name, $v->quantity, $v->price, $v->category, $v->variation, $v->token);
    }


    protected function updateProduct($value)
    {
        $v = (object)$value;
        $this->updateItem($v->idProduct, $v->idPrice, $v->quantity, $v->category, $v->variation, $v->token);
    }

    protected function deleteProduct($value)
    {
        $v = (object)$value;
        $this->deleteItem($v->idProduct, $v->variante);
    }


    public function getToken($price,$sku)
    {
        return $this->cryptToken($price,$sku);
    }


    public function getCart($value)
    {

    }


}

@session_start();
$myCart = !isset($_SESSION['jxCart']) ? $_SESSION['jxCart'] = new jxCart() : unserialize($_SESSION['jxCart']);