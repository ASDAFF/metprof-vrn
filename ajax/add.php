<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if( !empty( $_GET["id"] ) )
    $id = (int)$_GET["id"];

if( !empty( $_GET["quantity"] ) )
    $quantity = $_GET["quantity"];
else
    $quantity = 0;

if( !$id )
    die( 'Ошибка добавления товара в корзину' );

CModule::IncludeModule( 'catalog' );
CModule::IncludeModule( 'sale' );

if($quantity > 20 OR (int)$_GET["type"] == 5){
    if( Add2BasketByProductID( $id, $quantity ) )
        print 'Товар успешно добавлен в корзину';
    else
        print 'Товара нет в наличии';
}


?>