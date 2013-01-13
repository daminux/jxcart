<?php
// PUT THIS PHP CODE ON ALL PAGE
define('VHOST', 'jxcart.edatamart.fr'); //Without http:// and last /
define('DFTEMPLATE', 'topCart'); //Default view Template see in Tempalte Folder (without .tpl.php extension)
define('DND', 0); // ACTIVE Drag n Drop Cart Capacity
include 'core/jxCart.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>jxCart Free Jquery Cart || Simple to integrate as You whish</title>
    <meta charset="UTF-8">
    <meta name="description" content="Free jQuery Cart for shopping website">
    <link rel="stylesheet" href="http://<?= VHOST; ?>/css/style.css" type="text/css">
    <link rel="stylesheet" href="http://<?= VHOST; ?>/css/jxcart.css" type="text/css">
    <script type="text/javascript" src="http://<?= VHOST ?>/js/jquery-1.8.3.min.js"></script>
    <script src="http://<?= VHOST ?>/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript"> var HOST = '<?= VHOST ?>', DND = <?= DND ?>; </script>
    <script type="text/javascript" src="http://<?= VHOST ?>/js/jxCart.js"></script>

</head>
<body>
<div id="wrapper">
    <h1>CHECKOUT</h1>
    <div id="productsCheckout">
        <ul>
            <? foreach ($myCart->getCart() as $item) : ?>
            <li class="productChekcout">
                <?= $item->idProduct ?> | <?= $item->category ?> | <?= $item->name ?> | <?= $item->quantity ?>
                | <?= $item->price ?> € | <?= $item->total ?> €

                <? if (!empty($item->variation)): ?>
                <ul>
                    <? foreach ($item->variation as $variation) : ?>
                    <li>
                        <?= $item->name ?> :  <?= $variation->variation?> || <?= $variation->quantity?>
                    </li>
                    <? endforeach; ?>
                </ul>
                <? endif;?>
            </li>
            <? endforeach;?>
        </ul>
    </div>
</div>
</body>
</html>