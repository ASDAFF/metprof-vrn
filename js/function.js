
function replaseBasketTop() {
    $.ajax({
        url: '/ajax/basket.php',
        type: 'get',
        success: function (data) {
            $('.header__cart').replaceWith(data);
        }
    })
}





function addToBasket2(idel, quantity,el,type) {

        var countFull = parseFloat($('#order-table').attr('count-full'));

        $.ajax({
            url: '/ajax/maxQuantity.php?id='+idel,
            type: 'get',
            success: function (quaMin) {

            if(quaMin){
                var qu = quantity;
                quantity *= parseFloat(quaMin);
            }

            if(countFull < 20 && type == 6){
                alertify.error("Минимальный заказ 20м2");
                return false;
            }

            if(countFull >= 20 && type == 6){

                    var props = [
                        {
                            NAME:"длина листа",
                            CODE:"WIDTH_LIST",
                            VALUE:$(el).attr('data-list')
                        },
                        {
                            NAME:"кол-во м²",
                            CODE:"SQUARE",
                            VALUE:$(el).attr('data-count')
                        }
                    ];
                $(el).remove();
                el = $('#button-cart-offers');
            }

            quantity = parseFloat(quantity);

            $href = "/ajax/add.php";
            var _result = true;
                $.ajax({
                    url: $href,
                    type: 'post',
                    data:{
                        id:idel,
                        quantity:quantity,
                        type:type,
                        props:props
                    },
                    success: function (data) {
                        if (data == 'Товар успешно добавлен в корзину') {
                            replaseBasketTop();
                            alertify.success(data);
                            if(el){
                                $(el).text('Перейти в корзину');
                                $(el).attr('onclick','window.location.href="/personal/cart/"');
                            }
                            yaCounter48970379.reachGoal('korzina250720181506');
                        } else {
                            alertify.error(data);
                            _result = false;
                        }

                        if(quaMin && _result){
                            alertify.success("Добавлено "+ qu +" упаковка(и) " +quaMin+ "шт.");
                        }
                        return _result;

                    }
                });
            }
        });



}

function setCupon(){
    var numCupon = $('#coupon').val();
    if(numCupon){
        $.ajax({
            type: "GET",
            url: "/ajax/set_cupon.php?cupon="+numCupon,
            success: function(msg){
                if(msg)
                {

                    UpdateBigBasket();
                    alertify.success("Купон активирован!");
                }
                else
                {
                    alertify.error("Купон не найден");
                }
            }
        });
    }else{
        alertify.error('Введите номер купона!');
        return false;
    }

}

function inputQuntly(max,count,id){
    if(count < 1){
        $('.quantity#'+id+' input').val(1);
        alertify.error("Запрашиваемое кол-во. На складе нет");
        return false;
    }
    if(count > max){
        $('.quantity#'+id+' input').val(max);
        alertify.error("Запрашиваемое кол-во превышает остаток. На складе: " + max);
        return false;
    }else{
        var data="id="+id+"&quant="+count;
        ChangeCount(data);
    }
}


function basketPlus(max,count,id){
    var increm = parseInt(count)+1;

    if(increm > max){
        $('.quantity#'+id+' input').val(max-1);
        alertify.error("Запрашиваемое кол-во превышает остаток. На складе: " + max);
        return false;
    }else{
        var data="id="+id+"&quant="+increm;
        ChangeCount(data);
    }
}

function basketMinus(max,count,id){
    var increm = parseInt(count)-1;
    if(increm < 1){
        $('.quantity#'+id+' input').val(1);
        alertify.error("Запрашиваемое кол-во. На складе нет");
        return false;
    }else{
        var data="id="+id+"&quant="+increm;
        ChangeCount(data);
    }
}

function ChangeCount(data)
{
    $.ajax({
        type: "GET",
        url: "/ajax/change_count.php",
        data:data,
        success: function(msg){
            if(msg!="error")
            {
                 UpdateBigBasket();
            }
            else
            {
                alertify.error("");
            }
        }
    });
}
function UpdateBigBasket(){
    $.ajax({
        type: "GET",
        url: "/ajax/big_basket.php",
        data:"",
        success: function(msg){
            if(msg!="error")
            {
                $(".page_content").html(msg);
            }
            else
            {
                alertify.error("Произошла ошибка. Попробуйте повторить запрос позже");
            }
        }
    });
}

function deleteBasket(){
    $.ajax({
        type: "GET",
        url: "/ajax/delete_all_basket.php",
        data:"",
        success: function(msg){
            if(msg!="error")
            {
                UpdateBigBasket();
            }
            else
            {
                alertify.error("Произошла ошибка. Попробуйте повторить запрос позже");
            }
        }
    });
    return false;
}

function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands

    var i, j, kw, kd, km;

    // input sanitation & defaults
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


    return km + kw + kd;
}


//Удаление длины листа в детальной карте товара
function delRow(El) {
    $(El).parent().parent().remove();
}



function updatePrice(El, val) {
    if (!val)
    {
        $(El).attr('value', 0);
        val = 0;
    }
    if (val < 0) {
        $(El).attr('value', 0);
        val = 0;
        return false;
    }

            var sq_full = 0;
            var width_list = {};

            var _elements = $(".order-cnt");

            _elements.each(function (i, _el) {
                val = $(_el).find('input[name=_quantity]').val();
                var dv = $(_el).find('.drop-value');
                var length_part = (dv.length > 0) ? parseFloat($(_el).find('.drop-value').html()) : parseFloat($(_el).find('input[name=length]').val().replace(',', '.') * 1000);
                var width_part = $("input[name=width]").val();
                var sq = width_part * length_part * val / 1000000;
                width_list = sq
                sq_full = sq_full + sq;
                $('#order-table').attr('count-full',sq_full);
            });

            $('#count_product').val(sq_full);

            _elements.each(function (i, _el) {

                val = $(_el).find('input[name=_quantity]').val();
                var dv = $(_el).find('.drop-value');
                var length_part = (dv.length > 0) ? parseFloat($(_el).find('.drop-value').html()) : parseFloat($(_el).find('input[name=length]').val().replace(',', '.') * 1000);
                var width_part = $("input[name=width]").val();
                var sq = width_part * length_part * val / 1000000;

                if (width_part) {
                    var price = parseFloat(sq * parseFloat($(_el).attr('data-price')));
                } else {
                    var price = parseFloat(((length_part * val) / 1000) * parseFloat($(_el).attr('data-price')));
                }

                $(_el).attr('data-count',sq);
                $(_el).find('.sq').empty().append(sq + ' м²');
                $(_el).find('.price_in-table').empty().append(number_format(parseFloat(price), 2, '.', ' ') + '₽');

            });
}


$(function(){

    $('.catalog-sections-text').readmore({
        speed: 75,
        maxHeight: 160,
        moreLink: '<a href="#" style="border-bottom:snow">Подробнее...</a>',
        lessLink: '<a href="#" style="border-bottom:snow">Скрыть</a>'
    });
    $('.col-txt > .catalog-sections-text-hidden').readmore({
        speed: 75,
        maxHeight: 160,
        moreLink: '<a href="#" style="border-bottom:snow">Подробнее...</a>',
        lessLink: '<a href="#" style="border-bottom:snow">Скрыть</a>'
    });

    $('.category__show').click(function(){
       var than = $(this);
        than.parent().find('.toggle_product_no').slideToggle();
        return false;
    });


    //РћРїСЂРµРґРµР»РµРЅРёРµ СЏС‡РµР№РєРё
    $('#available-length').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var item = button.data('item');
        $(this).find('table').attr('data-td', item);
        //alert(item);
    });
    //Выбор длины в карточке товара.
    $("#available-length td").bind('click', function () {
        if (!$(this).hasClass('disable')) {
            var data_item = $("#av-length-table").attr('data-td');
            $("td[data-item='" + data_item + "'] div.drop-value").empty().append($(this).html() + ' мм');
            $("td[data-item='" + data_item + "']").parent().attr('data-list',$(this).html());

            $("td[data-item='" + data_item + "']").parent().attr('data-id',$(this).attr('data-id'));
            $("td[data-item='" + data_item + "']").parent().attr('data-idblock',$(this).attr('data-idblock'));
            $("td[data-item='" + data_item + "']").parent().attr('data-price',$(this).attr('data-price'));
            $("#available-length").modal('hide');

            updatePrice($("td[data-item='" + data_item + "'] div.drop-value").parent().parent().parent().find('input[name=_quantity]'), $("td[data-item='" + data_item + "'] div.drop-value").parent().parent().parent().find('input[name=_quantity]').val());
        }
    });




    //Добавление длины листа в детальной карте товара
    $(".p-view__order-table-add").bind('click', function () {
        var seconds = new Date().getTime();
        if ($(this).attr('data-type') != 'p23') {
            $("#order-table").append('<tr class="order-cnt">' +
                '<td data-toggle="modal" data-target="#available-length" data-item="item-' + seconds + '">' +
                '<div class="dropdown dropdown_double-icon dropdown-modal">' +
                '<div class="drop-value">0 мм</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class="dropdown dropdown_double-icon">' +
                '<input name="_quantity" type="number" max="50000" style="width: 60px;" placeholder="0 шт" onkeyup="updatePrice(this, $(this).val())" onchange="updatePrice(this, $(this).val())" onkeypress="return event.charCode >= 48 && event.charCode <= 57">' +
                '</div>' +
                '</td>' +
                '<td class="sq">' +
                '0 м²' +
                '</td>' +
                '<td>' +
                '<span class="price_in-table">0 ₽</span>' +
                '<button class="no-style p-view__order-table-del" onclick="delRow(this)">&times;' +
                '</button>' +
                '</td>' +
                '</tr>');
        } else {
            $("#order-table").append('<tr class="order-cnt">' +
                '<td data-toggle="modal" data-target="#available-length" data-item="item-' + seconds + '">' +
                '<div class="dropdown dropdown_double-icon dropdown-modal">' +
                '<div class="drop-value">0 мм</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class="dropdown dropdown_double-icon">' +
                '<input name="_quantity" type="number" max="50000" style="width: 60px;" placeholder="0 шт" onkeyup="updatePrice(this, $(this).val())" onchange="updatePrice(this, $(this).val())" onkeypress="return event.charCode >= 48 && event.charCode <= 57">' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<span class="price_in-table">0 ₽</span>' +
                '<button class="no-style p-view__order-table-del" onclick="delRow(this)">&times;' +
                '</button>' +
                '</td>' +
                '</tr>');
        }
    });



    $("#button-cart-offers").bind('click',function(){
        var el = $(this).closest('.data-square').find('.order-cnt');

        el.each(function (i, el) {
            var id = $(el).attr('data-id');
            var count = $(el).attr('data-count');
            var list = $(el).attr('data-list');
            if(count <= 0 || count == undefined){
                alertify.error("Не указано количество, товар " + list + " мм. не добавлен" );
            }else{
                addToBasket2(id,count,el,6);
            }
        });

    });



    $('#modal-form-size').ajaxForm({
        url:"/ajax/modal_size_form.php",
        type:"post",
        dataType:"json",
        success:function(responseText, statusText, xhr, $form){
            if(responseText.response){
                alertify.success("Сообщение отправлено!");
                $form.html("<div class='alert alert-success' role='alert'><strong>Сообщение отправлено!</strong> Номер обращения: " + responseText.data + ". </div>");
            }else{
                alertify.error(responseText.data);
            }
        }
    });

    $.get('/ajax/popover.php', function(data) {
        if(data.response){
            var popoverTemp = '<div class="popover" role="tooltip">'
                + '<div class="arrow"></div>'
                + '<h3 class="popover-title"></h3>'
                + '<div class="popover-content"></div>'
                + '<div class="popover-button">'
                + '<button type="button" class="btn btn-default" onclick="destroyPopover()">Ok</button>'
                + '</div>'
                + '</div>';

            $('#order-table').popover({
                "delay" : {"show" : 1000},
                "title" : "Длинна листа и количество.",
                "content" : "Выберете необходимую длину и количество листов.",
                "placement" : "left",
                "template" : popoverTemp
            }).trigger('click');

            $('#popover-button-cart').popover({
                "delay" : {"show" : 1000},
                "title" : "Добавление в корзину.",
                "content" : "После выбора всех листов положите все в корзину.",
                "placement" : "bottom",
                "template" : popoverTemp
            }).trigger('click');

            $('#popover-button-cart-table-add').popover({
                "delay" : {"show" : 1000},
                "container" : "body",
                "title" : "Лист другого размера.",
                "content" : "Если требуется доп.товар с другой длиной нажмите здесь.",
                "placement" : "right",
                "template" : popoverTemp
            }).trigger('click');
        }else{
            console.log("Вы уже ученый!");
        }
    }, "json");

});

function destroyPopover(){
    $('#order-table, #popover-button-cart, #popover-button-cart-table-add').popover('destroy');
    $.get('/ajax/popover.php', { button : true });
}

