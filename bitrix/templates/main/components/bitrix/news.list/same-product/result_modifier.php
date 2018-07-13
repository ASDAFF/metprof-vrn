<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

foreach($arResult["ITEMS"] as &$arItem){

    $IBLOCK_ID = $arItem['IBLOCK_ID'];
    $ID = $arItem['ID'];
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);
    if (is_array($arInfo))
    {
        $rsOffers = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $ID));
        while ($arOffer = $rsOffers->GetNext())
        {
            $arItem['OFFERS'] = $arOffer;
        }
    }
}

?>