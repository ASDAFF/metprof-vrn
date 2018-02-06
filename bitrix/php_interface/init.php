<?php

function price($id){
    $ar_res_price = CPrice::GetBasePrice($id, false, false);
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
            $arSelect = Array("ID", "IBLOCK_ID","DETAIL_PAGE_URL","PREVIEW_PICTURE","DETAIL_PICTURE", "NAME", "PROPERTY_*");//IBLOCK_ID � ID ����������� ������ ���� �������, ��. �������� arSelectFields ����
            $arFilter = Array("IBLOCK_ID" => 21, "CODE" => $code);
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