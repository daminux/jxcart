<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damien PICHEVIN
 * Date: 02/01/13
 * Time: 14:30
 *
 */

?>
<div id='bottomCart_list'>
    <ul>
        <? if (!empty($cart)): ?>
        <? foreach ($cart as $product): ?>
            <li data-id="3">
                <span class="name"> <?= $product->name ?> (<?= $product->quantity ?>)</span>
            </li>
            <? endforeach; ?>
        <? else: ?>
        <center>Cart empty</center>
        <? endif; ?>
    </ul>
</div>