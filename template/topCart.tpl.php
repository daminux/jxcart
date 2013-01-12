<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damien PICHEVIN
 * Date: 30/12/12
 * Time: 11:23
 *
 */

?>
<?= $totalCart->totalPrice . ' ||' . $totalCart->totalQuantity . ' item(s)' ?>
<div id='topCart_list'>
    <ul>
        <? if (!empty($cart)): ?>
        <? foreach ($cart as $product): ?>
            <li data-id="3">
                <span class="name"><?=$product->total?> |<?=$product->variante?> <?= $product->name ?> (<?= $product->quantity ?>)</span>
                <input type="text" value="<?= $product->quantity ?>" class="count">
                <a class="removeProduct" href='?action=deleteProduct&idProduct=<?= $product->idProduct ?>'>x</a>
            </li>
            <? endforeach; ?>
        <? else: ?>
        <center>Cart empty</center>
        <? endif; ?>
    </ul>
</div>
