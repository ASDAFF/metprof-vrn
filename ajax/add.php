<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if( !empty( $_POST["id"] ) )
    $id = (int)$_POST["id"];

if( !empty( $_POST["quantity"] ) )
    $quantity = $_POST["quantity"];
else
    $quantity = 0;

if( !$id )
    die( 'Ошибка добавления товара в корзину' );

CModule::IncludeModule( 'catalog' );
CModule::IncludeModule( 'sale' );

if($_POST['props']){
    Add2BasketByProductID( $id, $_POST['props'][1]['VALUE'], array(),$_POST['props']);
    print 'Товар успешно добавлен в корзину';
}else{

    if($quantity > 20 OR (int)$_POST["type"] == 5){
        if( Add2BasketByProductID( $id, $quantity ) )
            print 'Товар успешно добавлен в корзину';
        else
            print 'Товара нет в наличии';
    }
}




?>