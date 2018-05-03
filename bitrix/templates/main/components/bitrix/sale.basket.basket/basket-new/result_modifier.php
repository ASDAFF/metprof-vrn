<?php

$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
    "delete" => $curPage."delete&id=#ID#",
    "delay" => $curPage."delay&id=#ID#",
    "add" => $curPage."add&id=#ID#",
);
unset($curPage);

foreach($arResult["GRID"]["ROWS"] as &$row){

    $mxResult = CCatalogSku::GetProductInfo($row['PRODUCT_ID']);
    if (is_array($mxResult))
    {
        $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
        $arFilter = Array("IBLOCK_ID" => $mxResult['IBLOCK_ID'], "ID" => $mxResult['ID'], "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($arFields = $res->GetNext())
        {
            $row['DETAIL_PAGE_URL'] = $arFields['DETAIL_PAGE_URL'];
        }
    }

}