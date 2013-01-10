jxcart
======
IMPORTANT :
I'm a Php Short Open Tag lover, it  use in all the code so be careful change this or setting your PHP.INI with Short_Open_Tag =  On !


WHAT IS jxCART :
----------------
jxCart is a cart PHP class with Jquery Capacity, using MVC template pattern.
It's fun and very easy to use it !


WHAT jxCART DOING FO YOU :
-------------------------

 * cart capacity
 * ajax capacity
 * multiple cart and multi cart template in page
 * Add with Link simple and secure
 * Add with form
 * Secure Price & sku (injection firewall)
 * Payement management
 * Drag and drop (from add link & aff form)
 * Select Quantity
 * Select variante (uniq price by product)
 * Secure token (hash SHA256 + session controle + passphrase)


HOW TO USE JXCART :
------------------
Cart JQuery Capacity is provided by 'class' and template by 'id'.
Just edit index.php and play.

Add product :
-------------

with link (href) : <a class="addProduct" href='?action=addProduct&idProduct=123123&name=blue socketprice10.50&quantity=1&category=&token=<?=jxCart::token('10.50','123123')?>'> [What you want here] </a>
IMPORTANTE :
* Class need case sensitive
* <?=jxCart::token('price','idProduct')?> // is a token


with form (hidden field)
<input type="hidden" value="Fish n Chips" name="name">
<input type="hidden" value="11.75" name="price">
<input type="hidden" value="20cv23d" name="idProduct">
<input type="hidden" value="addProduct" name="action">
<input type="hidden" value="<?=jxCart::token('11.75','20cv23d')?>" name="token">










To Know :





