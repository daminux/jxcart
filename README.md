jxcart
======
IMPORTANT :
I'm a Php Short Open Tag lover, it  use in all the code so be careful change this or setting your PHP.INI with Short_Open_Tag =  On !


WHAT IS jxCART :
----------------
jxCart is a cart PHP class with Jquery Capacity, using MVC template pattern.
It's fun and very easy to use it !


WHAT jxCART DOING FOR YOU :
-------------------------

 * Cart capacity
 * Ajax capacity
 * Drag and drop (from add link & add form)
 * Multiple cart and multi cart template in page
 * Add with Link simple and secure
 * Add with form with input hidden
 * Secure Price & sku (injection firewall)
 * Manage Quantity &  variation (no multiple variation pricing)
 * Secure token (hash SHA256 + session control + passphrase)
 * Voucher / Coupon Discount


ROADMAP :
=========

NEXT RAPID EVOLUTION  :
----------------------
 * Delete item variation
 * Shipment management
 * Universal Payement Gateway
 * Cart Abort stimulus by email
 * Manage multiple variation pricing and secure variation pricing injection


POSSIBLE CHANGES IN MEDIUM/LONG TERM :
-------------------------
New Module : Item & Sales management
* Item import by Excel, CSV File or someThing like that.
* Item & sales Storage via SQLITE3
* Order and invoice management.

New Module : URL Dispatcher
* Implement an improving  URL/PRODUCT dispatcher


HOW TO USE JXCART :
------------------

Cart JQuery Capacity is provided by 'class' and template by 'id'.
Just edit index.php and play.


ADD PRODUCT :
-------------

with link (href) :<_a class="addProduct" href='?action=addProduct&idProduct=123123&name=blue socketprice10.50&quantity=1&category=&token=<?=jxCart::token('10.50','123123')?>'> [What you want here] </a>
IMPORTANTE :
* Class need case sensitive
* <?=jxCart::token('price','idProduct')?> // is a token


with form (hidden field)
<_input type="hidden" value="Fish n Chips" name="name">
<_input type="hidden" value="11.75" name="price">
<_input type="hidden" value="20cv23d" name="idProduct">
<_input type="hidden" value="addProduct" name="action">
<_input type="hidden" value="<?=jxCart::token('11.75','20cv23d')?>" name="token">