<?
// PUT THIS PHP CODE ON ALL PAGE
define('VHOST', 'jxcart.edatamart.fr');
define('DFTEMPLATE', 'topCart'); //Default view Template see in Tempalte Folder (without .tpl.php extension)
include 'core/jxCart.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>jxCart Free Jquery Cart || Simple to integrate as You whish</title>
    <meta charset="iso-8859-1">
    <meta name="description" content="Free jQuery Cart for shopping website">
    <link rel="stylesheet" href="http://jxcart.edatamart.fr/css/style.css" type="text/css">
    <link rel="stylesheet" href="http://jxcart.edatamart.fr/css/jxcart.css" type="text/css">
    <script type="text/javascript" src="http://jxcart.edatamart.fr/js/jquery-1.8.3.min.js"></script>
    <script src="http://jxcart.edatamart.fr/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="http://jxcart.edatamart.fr/js/jxCart.js"></script>
</head>

<body>
<div id="wrapper">
    <div class="jxCart" id="topCart">
        <?= $myCart->displayCart() //No argument use default template ?>
    </div>


    <div id="products">
        <ul>
            <li class="product">
                <a class="addAction" href="?action=addProduct&name=Socket fishman&price=8.40&idProduct=201U34&token=<?= $myCart->getToken('8.40')?>">
                    <img alt="" src="http://jxcart.edatamart.fr/css/images/5.jpg">
                    <h3>Socket Fishman <br/><b>8,40 EUR</b></h3></a>
            </li>
            <li class="product">
                <p>Optical Mouse <br/><b>12,60EUR</b></p>
                <span class="count">1</span>
                <a class="addAction"
                   href="?action=addProduct&name=Optical Mouse&price=12.60&idProduct=201k34&quantity=1&token=<?= $myCart->getToken('12.60')?>">AddToCart</a>
            </li>
            <li class="product">
                <p>Something like that<br/> <b>9,80 EUR</b></p>
                <span class="count">1</span>
                <a class="addAction"
                   href="?action=addProduct&name=Something like that&price=9.80&idProduct=20h234&quantity=1&token=<?= $myCart->getToken('9.80')?>">AddToCart</a>

            </li>
            <li class="product">
                <p>Once upon a time<br/> <b>36,75 EUR</b></p>
                <span class="count">1</span>
                <a class="addAction"
                   href="?action=addProduct&name=Once upon a time&price=36.75&idProduct=2j1234&quantity=1&token=<?= $myCart->getToken('36.75')?>">AddToCart</a>

            </li>
            <li class="product">
                <p>Fish n Chips <br/><b>11,75 EUR</b></p>
                <span class="count">1</span>
                <a class="addAction"
                   href="?action=addProduct&name=Fish n Chips&price=11.75&idProduct=2012i4&quantity=1&token=<?= $myCart->getToken('11.75')?>">AddToCart</a>

            </li>
            <li class="product">
                <form class='product addAction' method="POST" action="/">
                    <select name="quantity">
                        <? for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i?>"><?= $i?></option>
                        <? endfor;?>
                    </select>
                    <input type='hidden' name="name" value="Fish n Chips"/>
                    <input type='hidden' name="price" value="11.75"/>
                    <input type='hidden' name="idProduct" value="20cv23d"/>
                    <input type='hidden' name="action" value="addProduct"/>
                    <input type='hidden' name="token" value="<?= $myCart->getToken('11.75')?>"/>
                    <input type='submit' name="submit" value="ajouter"/>
                </form>
                Fish n Chips<br/>11,75 EUR
            </li class="product">
        </ul>
    </div>


</div>
</body>
</html>