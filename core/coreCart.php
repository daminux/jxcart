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
    CONST MYCRYPT = 'monCryptage';

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

    protected function cryptToken($price)
    {

        $iv = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        return rawurlencode(mcrypt_encrypt(MCRYPT_BLOWFISH, MYKEY, $this->_token . '::' . $price, MCRYPT_MODE_ECB, $iv));

    }

    protected function decryptToken($token)
    {
        $out = null;

        $iv = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $chaine = mcrypt_decrypt(MCRYPT_BLOWFISH, MYKEY, $token, MCRYPT_MODE_ECB, $iv);
        if (isset($chaine)) {
            $val = explode('::', $chaine);
            $out = new stdClass();
            $out->token = $val[0];
            $out->price = $val[1];
        }
        return $out;
    }

    protected function calcCart()
    {
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($this->_cartProducts as $item) {
            $totalPrice = number_format($totalPrice + $item->total, 2);
            $totalQuantity += $item->quantity;
        }
        $this->_cartTotal->totalPrice = $totalPrice > 0 ? $totalPrice : ''; //Prix à Blnc
        $this->_cartTotal->totalQuantity = $totalQuantity > 0 ? $totalQuantity : 0; // qut à 0

        $this->setData(array('totalCart' => $this->_cartTotal));
    }

    protected function addItem($sku, $name, $quantity, $price, $category = null, $variation = null, $token)
    {

        $decrypted = $this->decryptToken(rawurldecode($token));
        if ($this->_token == $decrypted->token && number_format($price, 2) == number_format($decrypted->price, 2)) {

            if ($quantity < 1)
                $quantity = 1;

            if (isset($this->_cartProducts[$sku])) {

                $this->_cartProducts[$sku]->quantity += $quantity;
                if (isset($this->_cartProducts[$sku]->variation))
                    $this->_cartProducts[$sku]->variation[$variation]->quantity += $quantity;

            } else {
                $product = new stdClass();
                $product->price = $price;
                $product->name = $name;
                $product->category = $category;
                $product->variation[$variation] = new stdClass();
                $product->variation[$variation]->quantity = $quantity;
                $product->quantity = $quantity;
                $product->idProduct = $sku;
                $this->_cartProducts[$sku] = $product;
            }

        } else {
            // GESTION DERREUR

        }


        if (!self::is_ajax())
            self::redirect('');

    }

    protected function deleteItem($sku, $variante)
    {

        if (isset($variante) && $this->_cartProducts[$sku]->variante[$variante]) {
            $this->_cartProducts[$sku]->quantity -= $this->_cartProducts[$sku]->variante[$variante]->quantity;
            unset($this->_cartProducts[$sku]->variante[$variante]);
        } else {
            unset($this->_cartProducts[$sku]);
        }

        if (!self::is_ajax())
            self::redirect('');
    }

    protected function updateItem($sku, $quantity, $category = null, $variation = null)
    {
        if ($quantity < 0)
            $quantity = 1;

        $this->_cartProducts[$sku]->quantity = $quantity;
        $this->_cartProducts[$sku]->variation[$variation] = $variation;
    }

    protected function cartSummary()
    {
        $this->_cartProducts;
    }

    private function securePricing()
    {

        echo '';

    }

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

    // ** STATIC FUNCTION

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