<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>

hello test!

<?

var_dump(Add2BasketByProductID( 42073, 20, array(),array("NAME" => 1,"CODE" => "WIDTH_LIST","VALUE" => "3300")));

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>