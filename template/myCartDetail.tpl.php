<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damien PICHEVIN
 * Date: 30/12/12
 * Time: 11:23
 *
 */
?>
<!--Product Object Description-->
<? if (!empty($cart)): ?>
<ul>
    <? foreach ($cart as $product): ?>
    <li>Product : <?= $product->name?> | Price : <?= $product->price ?> | Quantite : <?= $product->quantity?> | Total
        : <?= number_format($product->price * $product->quantity, 2)  ?></li>
    <? endforeach;?>
</ul>
<? else: ?>
<center>Panier Vide</center>
<? endif; ?>