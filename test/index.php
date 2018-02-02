<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>

hello test!

<?

$res = CIBlockElement::GetByID(33325);
if($ar_res = $res->GetNext()){
    $nav = CIBlockSection::GetNavChain(false, $ar_res['IBLOCK_SECTION_ID']);
    $code_section = $nav->arResult[0]['CODE'];
}

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>