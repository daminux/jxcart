<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damien PICHEVIN
 * Date: 30/12/12
 * Time: 11:02
 *
 */
ini_set( "short_open_tag",1);
require_once 'coreCart.php';

class jxCart extends coreCart
{


    protected function addProduct($value)
    {
        $v = (object)$value;

        $this->addItem($v->idProduct, $v->name, $v->quantity, $v->price, $v->category, $v->variation,$v->token);
        $this->calcTotal($v->idProduct);
    }


    protected function deleteProduct($value)
    {
        $v = (object)$value;
        $this->deleteItem($v->idProduct, $v->variante);
    }


    protected function updateProduct($value)
    {
        $v = (object)$value;
        $this->updateItem($v->idProduct, $v->quantity, $v->category, $v->variation);
        $this->calcTotal($v->idProduct);

    }


    protected function calcTotal($sku)
    {
        $this->_cartProducts[$sku]->total = number_format($this->_cartProducts[$sku]->quantity * $this->_cartProducts[$sku]->price, 2);

    }


    public function getToken($price)
    {
        return $this->cryptToken($price);
    }


    public function getCart($value)
    {

    }


}

@session_start();
$myCart = !isset($_SESSION['jxCart']) ? $_SESSION['jxCart'] = new jxCart() : unserialize($_SESSION['jxCart']);