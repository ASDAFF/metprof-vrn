<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule( 'iblock' );

$name = strip_tags($_REQUEST['name']);
$size = strip_tags($_REQUEST['text']);
$phone = strip_tags($_REQUEST['phone']);

if(!$name && !$size && !$phone)
    return false;

$preview = "";
$preview .= "Длина и количество: $size\n";
$preview .= "ФИО: $name\n";
$preview .= "Телефон: $phone\n";

$arLoadProductArray = Array(
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => 33,
    "NAME"           => $name,
    "ACTIVE"         => "N",            // активен
    "PREVIEW_TEXT"   => $preview,
);

$el = new CIBlockElement;
if($PRODUCT_ID = $el->Add($arLoadProductArray))
    echo json_encode(array("response" => true,"data" => $PRODUCT_ID));
else
    echo json_encode(array("response" => false,"data" => $el->LAST_ERROR));
