<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damien PICHEVIN
 * Date: 30/12/12
 * Time: 11:01
 *
 */


class coreCart
{
    protected $_token = '';
    protected $_cartProducts = array();
    protected $_carTotal = array();
    protected $_request = '';
    protected $_dataRender = array();
    protected $_actions = array('addProduct', 'deleteProduct', 'updateProduct', 'getCart', 'updateCart', 'feedbackPayment');
    protected $_defaultCartTemplate = DFTEMPLATE;
    const MYCRYPT = 'ma cle de hashage de secrete';

    function __construct()
    {
        $this->_request = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'getCart'; // getCart encore utile ?
        if (in_array($this->_request, $this->_actions)) {
            $this->_token = isset($_SESSION['jxToken']) ? $_SESSION['jxToken'] : $_SESSION['jxToken'] = uniqid();
            $params = $_REQUEST;
            unset($params['action']);
            call_user_func_array(array($this, $this->_request), array($params));
            $this->setData(array('cart' => $this->_cartProducts));
            $this->calcCart();
            if (self::is_ajax())
                $this->displayCart($params['template']);
        }

    }

    protected function setData($newData)
    {
        $this->_dataRender = array_merge($this->_dataRender, $newData);

    }

    public function displayCart($tpl = null)

    {
        if ($tpl == null)
            $tpl = $this->_defaultCartTemplate; // Default Cart Template
        if (strstr($tpl, '|')) // If more 1 cart in Page
            $tpl = explode('|', $tpl);
        if (is_array($tpl)) {
            foreach ($tpl as $template) {
                $out[$template] = $this->render($template);
            }
        } else {
            $out[$tpl] = $this->render($tpl);
        }

        if (self::is_ajax()) {
            $out = json_encode($out);
            echo $out;
            exit;
        }

        return $out[$tpl];
    }

    protected function render($tpl = null)
    {
        if ($tpl == null) // PARANO CONTROLE
            $tpl = $this->_defaultCartTemplate;
        ob_start();
        extract($this->_dataRender);
        require 'template/' . $tpl . '.tpl.php'; // AJOUTE LE CONTROLE SUR LA PRENSENCE DU TEMPLATE
        $html = ob_get_clean();
        return $html;
    }

    static function token($price, $sku, $category = null)
    {
        return hash('sha256', $price . $_SESSION['jxToken'] . $category . self::MYCRYPT . $sku, false);
    }

    protected function calcCart()
    {
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($this->_cartProducts as $item) {
            $totalPrice = number_format($totalPrice + $item->total, 2);
            $totalQuantity += $item->quantity;
        }
        $this->_cartTotal->totalPrice = $totalPrice > 0 ? $totalPrice : ''; //Prix � Blnc
        $this->_cartTotal->totalQuantity = $totalQuantity > 0 ? $totalQuantity : 0; // qut � 0

        $this->setData(array('totalCart' => $this->_cartTotal));
    }

    protected function addItem($sku, $name, $quantity, $price, $category = null, $variation = null, $token)
    {

        if (self::token($price, $sku, $category) == $token) {

            $quantity = $quantity < 1 ? 1 : $quantity;


            if (isset($this->_cartProducts[$sku])) {
                $this->_cartProducts[$sku]->quantity += $quantity;
                if (isset($variation)) {
                    $this->_cartProducts[$sku]->variation->$variation->variation = $variation;
                    $q = $this->_cartProducts[$sku]->variation->$variation->quantity += $quantity; // CHECK SI -1
                    $p = $this->_cartProducts[$sku]->variation->$variation->price = $price;
                    $this->_cartProducts[$sku]->variation->$variation->totalPrice = $q * $p;
                }

            } else {
                $product = new stdClass();
                $product->price = $price;
                $product->name = $name;
                $product->category = $category;
                if ($variation) {
                    $product->variation->$variation->variation = $variation;
                    $q = $product->variation->$variation->quantity += $quantity;
                    $p = $product->variation->$variation->price = $price;
                    $product->variation->$variation->totalPrice = $q * $p;
                }
                $product->quantity = $quantity;
                $product->idProduct = $sku;
                $this->_cartProducts[$sku] = $product;
            }

            $this->calcTotal($sku);

        }


        if (!self::is_ajax())
            self::redirect('');

    }

    protected function deleteItem($sku, $variation)
    {

        if (isset($$variation) && $this->_cartProducts[$sku]->variation[$variation]) {
            $this->_cartProducts[$sku]->quantity -= $this->_cartProducts[$sku]->variation[$variation]->quantity;
            unset($this->_cartProducts[$sku]->variation[$variation]);
        } else {
            unset($this->_cartProducts[$sku]);
        }

        if (!self::is_ajax())
            self::redirect('');
    }

    protected function updateItem($sku, $price, $quantity, $category = null, $variation = null, $token)
    {
        if (self::token($price, $sku, $category) == $token) {
            $quantity = $quantity <= 0 ? -1 : 1;

            $this->_cartProducts[$sku]->quantity = $quantity;
            $this->_cartProducts[$sku]->variation[$variation] = $variation;

            $this->calcTotal($sku);
        }
    }

    protected function calcTotal($sku)
    {
        $this->_cartProducts[$sku]->total = number_format($this->_cartProducts[$sku]->quantity * $this->_cartProducts[$sku]->price, 2);

    }

    protected function cartSummary()
    {
        return $this->_cartProducts;
    }

    // ** MAGIC METHOD
    function __sleep()
    {
        return array('_cartProducts');
    }


    function __wakeup()
    {
        $this->setData(array('cart' => $this->_cartProducts));
        $this->__construct();
    }


    function __destruct()
    {
        @session_start();
        $_SESSION['jxCart'] = serialize($this);
    }

    // ** STATIC METHOD

    static function is_ajax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    static function redirect($uri)
    {
        header('Location:http://' . VHOST . '/' . $uri);
    }
}