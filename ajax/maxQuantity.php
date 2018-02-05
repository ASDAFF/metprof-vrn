<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if( !empty( $_GET["id"] ) )
    $id = (int)$_GET["id"];

CModule::IncludeModule( 'catalog' );
$res = CIBlockElement::GetByID($id);
if($ar_res = $res->GetNext()){
    $nav = CIBlockSection::GetNavChain(false, $ar_res['IBLOCK_SECTION_ID']);
    $code_section = $nav->arResult[0]['CODE'];

    if($code_section == 'krepezhnye_izdeliya'){
        return print 250;
    }else{
        return false;
    }
}

?>