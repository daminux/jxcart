/**
 * Created with JetBrains PhpStorm.
 * User: shadam
 * Date: 30/12/12
 * Time: 12:17
 * To change this template use File | Settings | File Templates.
 */


$(document).ready(function () {
    iC = '.jxCart';
    function cD() {
        var cartEl = '';
        $(iC).each(function () {
            cartEl = cartEl + $(this).attr('id') + '|'
        });
        var cartEl = cartEl.substr(0, cartEl.length - 1);
        return cartEl;
    }
    //    ADD PRODUCT
    function dC(target, event) {
        var params = '';
        it = $(target);
        if (it.is('a')) {
            params = it.attr('href');
            params = params.substr(1, params.length);
        } else {
            params = it.serialize();
        }
        params = params + '&template=' + cD();
        //  console.log(event.type);
        var protocol = 'http://';
        var hostname = HOST + '/'
        $.get(protocol + hostname, params, function (data) {
            if (event.type == 'click' || event.type == 'submit') {
                tC(target)
            }
            $.each(data, function (index, El) {
                $('#' + index).html(El)
            })
        }, 'json');
    }
    $('a.addAction, a.removeProduct').live('click', function (event) {
        dC(this, event);
        return false;
    });
    $('form.addAction').live('submit', function (event) {
        dC(this, event);
        return false;
    });
    function tC(what) {
        $(iC).addClass('hover').delay(250).queue(function (next) {
            $(this).removeClass("hover");
            next();
        });
    }
    $("#products li").draggable({
        // Repositionne l'élément à sa place
        revert:true,
        // Ajoute CSS sélection / destinations sur drag
        drag:function (event, ui) {
            $(this).addClass("active");
            $(this).closest("#products").addClass("active");
        },
        // Supprimer CSS sélection / Destinations sur relache
        stop:function () {
            $(this).removeClass("active").closest("#products").removeClass("active");
        }
    });
    $(iC).droppable({
        // CSS Active quand  cart active
        activeClass:"active",
        // CSS Active quand cart hover
        hoverClass:"hover",
        // mode de détectionde drag sur drop
        tolerance:"touch",
        drop:function (event, ui) {
            // Récupére l'enfant form de la sélection courante et sérialize pour passé à doCart.
            var selection = ui.draggable;
            var params = selection.children('.addAction');
            dC($(params), event);
        }
    });
//    UPDATE PRODUCT
});
