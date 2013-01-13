<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damien PICHEVIN
 * Date: 30/12/12
 * Time: 11:23
 *
 */

?>
<center><?= !empty($totalCart->totalPrice) ? $totalCart->totalPrice . ' € (' . $totalCart->totalQuantity . ' item' . ( $totalCart->totalQuantity > 1 ? 's)' : ')' ) .' | <a href="checkout.php">checkout</a>' : 'Empty Cart';?></center>
<div id='topCart_list'>
    <ul>
        <? if (!empty($cart)): ?>
        <? foreach ($cart as $product): ?>
            <li data-id="3">
                <span class="name"><?=$product->total?> € |<?=$product->variante?> <?= $product->name ?>
                    (<?= $product->quantity ?>)</span>
                <input type="text" value="<?= $product->quantity ?>" class="count">
                <a class="removeProduct" href='?action=deleteProduct&idProduct=<?= $product->idProduct ?>'>x</a>
            </li>
            <? endforeach; ?>
        <? endif; ?>
    </ul>
</div>
