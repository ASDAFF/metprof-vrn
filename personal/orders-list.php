<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
$_REQUEST['filter_history'] = 'Y';
?>

<?
global $USER;
if ($USER->IsAuthorized()) {?>
   <?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list", 
	"personal-order-history", 
	array(
		"PATH_TO_DETAIL" => "javascript:void(0)",
		"PATH_TO_COPY" => "javascript:void(0)",
		"PATH_TO_CANCEL" => "javascript:void(0)",
		"PATH_TO_BASKET" => "/personal/cart/",
		"ORDERS_PER_PAGE" => "10",
		"ID" => "",
		"SET_TITLE" => "Y",
		"SAVE_IN_SESSION" => "N",
		"NAV_TEMPLATE" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"HISTORIC_STATUSES" => array(
			0 => "F",
			1 => "N",
			2 => "P",
		),
		"COMPONENT_TEMPLATE" => "personal-order-history",
		"PATH_TO_PAYMENT" => "payment.php",
		"PATH_TO_CATALOG" => "/catalog/",
		"RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "0",
		),
		"DEFAULT_SORT" => "STATUS",
		"ALLOW_INNER" => "N",
		"ONLY_INNER_FULL" => "N",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_P" => "yellow",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"REFRESH_PRICES" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
<?}else{
	LocalRedirect("/personal/order/make/",false,301);
}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>