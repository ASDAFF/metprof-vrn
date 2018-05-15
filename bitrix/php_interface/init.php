<?php

function price($id){
    $res = CCatalogSKU::getOffersList(
        $id,
        $iblockID = 24,
        $skuFilter = array("ACTIVE" => "Y"),
        $fields = array("CATALOG_PRICE_4"),
        $propertyFilter = array()
    );
    $id_offer = array_keys($res[$id])[0];

    $ar_res_price = CPrice::GetBasePrice($id_offer, false, false);
    if($ar_res_price['PRICE']){
        return $ar_res_price['PRICE'];
    }else{
        return false;
    }



}
function priceDiscount($id){
    global $USER;
    $ar_res_price = CCatalogProduct::GetOptimalPrice($id, 1, $USER->GetUserGroupArray(), 'N');
    if($ar_res_price['DISCOUNT_PRICE']){
        return $ar_res_price['DISCOUNT_PRICE'];
    }else{
        return false;
    }
}

function getUrlProd($url){
    if($url){
        $code = explode('/',$url);
        if($code[3]){
            $code = $code[3];
        }else{
           $code = $code[2];
        }

        if(CModule::IncludeModule("iblock")) {
            $arSelect = Array("ID", "IBLOCK_ID","DETAIL_PAGE_URL","PREVIEW_PICTURE","DETAIL_PICTURE", "NAME", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
            $arFilter = Array("IBLOCK_ID" => 24, "CODE" => $code);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            if($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                $arProps = $ob->GetProperties();
                $arResults = array_merge($arFields,$arProps);
                return $arResults;
            }
        }
    }

}

function isRootFolder($id,$root){

    CModule::IncludeModule( 'catalog' );
    $res = CIBlockElement::GetByID($id);
    if($ar_res = $res->GetNext()){
        $nav = CIBlockSection::GetNavChain(false, $ar_res['IBLOCK_SECTION_ID']);
        $code_section = $nav->arResult[0]['CODE'];

        if($code_section == $root){
            return true;
        }else{
            return false;
        }
    }
}