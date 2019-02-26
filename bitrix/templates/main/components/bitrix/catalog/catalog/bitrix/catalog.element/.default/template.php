<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

//var_dump($arResult);
?>
<script type="text/javascript">
    var viewedCounter = {
        path: '/bitrix/components/bitrix/catalog.element/ajax.php',
        params: {
            AJAX: 'Y',
            SITE_ID: "<?= SITE_ID ?>",
            PRODUCT_ID: "<?= $arResult['ID'] ?>",
            PARENT_ID: "<?= $arResult['ID'] ?>"
        }
    };
    BX.ready(
        BX.defer(function(){
            BX.ajax.post(
                viewedCounter.path,
                viewedCounter.params
            );
        })
    );
</script>

<?
//var_dump($arResult['OFFERS']);

$arOffers = array();
foreach($arResult['OFFERS'] as $offer){
    if($offer['MIN_PRICE']['DISCOUNT_VALUE']){
        $arOffers['ID'] = $offer['ID'];
        $arOffers['DISCOUNT_VALUE'] = $offer['MIN_PRICE']['DISCOUNT_VALUE'];
		$arOffers['BASE_PRICE'] = $offer['MIN_PRICE']['VALUE'];
        $arOffers['DISCOUNT_DIFF_PERCENT'] = $offer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
    }
	$arOffers['QUANTITY'] = $offer['CATALOG_QUANTITY'];
}
?>


<div class="prod_card cl">
   <div class="pc__prod-info">
      <h1><?=$arResult['NAME']?></h1>

<!--      <div class="pc__code">Код товара: <span>--><?//=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?><!--</span></div>-->

      <div class="cl">
         <div class="pc__prod-gallery cl">
            <div class="pg-thumbnails">
               <? foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key => $img):?>
               <div class="item <? if($key < 1): ?>active<? endif; ?>"><a href="#"><span>
                           <img src="<?=CFile::GetPath($img)?>" alt="<?=$arResult['NAME']?>"></span></a></div>
               <? endforeach; ?>

            </div>
            <div class="pg-current">
               <? foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key => $img):?>
               <a href="<?=CFile::GetPath($img)?>" class="<? if($key < 1): ?>active<? endif; ?>" data-fancybox="gallery<?=$arResult['ID']?>">
                   <img src="<?=CFile::GetPath($img)?>" alt="<?=$arResult['NAME']?>"></a>
               <? endforeach; ?>
            </div>
         </div>



          <div class="pc__buy-block cl">
              <div class="bb_compare">
                  <input type="checkbox" id="icompare" id-cat="<?=$arResult['IBLOCK_SECTION_ID']?>" value="<?=$arResult['ID']?>">
                  <label for="icompare">Сравнить</label>
              </div>

              <? if(empty($arOffers['DISCOUNT_VALUE'])): ?>
                  <h1>Цену уточняйте у менеджера</h1>
              <? else: ?>
                  <div class="bb_col">
                      <div class="price">
							  <div class="price-old"><span><?=$arOffers['BASE_PRICE']?></span> &#8381;/<?=$arResult['PROPERTIES']['CML2_BASE_UNIT']['VALUE'];?></div>
                              <div class="price-new"><span><?=$arOffers['DISCOUNT_VALUE']?></span>  &#8381;/<?=$arResult['PROPERTIES']['CML2_BASE_UNIT']['VALUE'];?></div>
                      </div>
                  </div>

                  <div class="bb_col right">
                      <div class="sale">
                          <? if($arOffers['DISCOUNT_DIFF_PERCENT']): ?>
                              <span>СКИДКА <?=$arOffers['DISCOUNT_DIFF_PERCENT'];?>%</span>
                          <? endif;?>
                          <span>при заказе<br>с сайта</span>
                      </div>

                      <?if(!$arResult['IS_M2']):?>
                          <div class="quantity">
                              <a class="minus na" href="#"></a>
                              <input type="text" value="1" max="<?=$arOffers['QUANTITY']?>" id="count_product"/>
                              <a class="plus" href="#"></a>
                          </div>
                          <script>
                              $('.quantity > .plus').click(function(){
                                  var count_val = $(this).parent().find('input').val();
                                  if(count_val >= <?=$arOffers['QUANTITY']?>){
                                      $(this).addClass('na');
                                      return false;
                                  }
                              });
                              $('.quantity > .minus').click(function(){
                                  $('.quantity > .plus').removeClass('na');
                              });
                          </script>
                      <?else:?>
                          <input type="hidden" name="count_product" id="count_product" value="0">
                      <?endif;?>

                  </div>
              <? endif; ?>

              <?if(isRootFolder($arResult['ID'],"krepezhnye_izdeliya")):?>
              <div class="buy-box-product">Продаётся упаковкой по 250 шт.</div>
              <? endif; ?>

              <?if(!$arResult['IS_M2']):?>

                  <? if($arOffers['DISCOUNT_VALUE'] and $arOffers['QUANTITY'] > 0): ?>
                      <a href="javascript:void(0)" class="add2cart" onclick="addToBasket2(<?=$arOffers['ID']?>, $('#count_product').val(),this,<?=$arResult['PROPERTIES']['CML2_BASE_UNIT']['DESCRIPTION']?>);">Добавить в корзину</a>
                  <?else:?>
                      <a href="javascript:void(0)" class="add2cart show-popup" data-id="order-product">Товар под заказ</a>
                  <?endif;?>

              <?endif;?>

            <a href="#" class="bb_btn show-popup" data-id="oneclick"><span>Купить<br>в один клик</span></a>
            <a href="#" class="bb_btn spec_help show-popup" data-id="specialist"><span>Помощь<br>специалиста</span></a>
         </div>
      </div>



      <div class="pc__tabs">
         <div class="t-list cl">
            <a href="#"><span>Описание</span></a>
            <a href="#"><span>Технические характеристики</span></a>
            <a href="#"><span>Отзывы </span></a>
            <a href="#" class="active"><span>Наличие в магазинах</span></a>
         </div>
         <div class="t-content">
            <div class="tab tab_des">
               <a href="#" class="mtb" onclick="return false">Описание</a>
               <div class="content">
                  <?=$arResult['DETAIL_TEXT']?>
                   <? foreach($arResult['PROPERTIES']['FILES']['VALUE'] as $key => $file): ?>
                   <p><a class="download" href="<?=CFile::GetPath($file);?>"><?=$arResult['PROPERTIES']['FILES']['DESCRIPTION'][$key];?></a></p>
                   <? endforeach; ?>
               </div>
            </div>
            <div class="tab tab_tec">
               <a href="#" class="mtb" onclick="return false">Технические характеристики</a>
               <div class="content">
                  <?
                  if (!empty($arResult['PROPERTIES']))
                  {
                     foreach($arResult['PROPERTIES'] as $property){
                         if(
                             $property['CODE']
                             and $property['CODE'] != "MORE_PHOTO"
                             and $property['CODE'] != "DLINA_1"
                             and $property['CODE'] != "DLINA_TEST"
                             and $property['CODE'] != "SALE"
                             and $property['CODE'] != "DUPUSTIMYE_RAZMERY_METALLOCHEREPITSA_MM"
                             and $property['CODE'] != "CML2_BASE_UNIT"
                             and $property['CODE'] != "RECOMEND_PRODUCT"
                         ){
                             if(is_array($property['VALUE'])) {
                                 ?>
                                 <div class="line cl">
                                     <div class="prop"><?= $property['NAME'] ?></div>
                                     <div class="val"><?= implode(",", $property['VALUE']) ?></div>
                                 </div>
                                 <?
                             }elseif($property['VALUE']){
                                 ?>
                                 <div class="line cl">
                                     <div class="prop"><?= $property['NAME'] ?></div>
                                     <div class="val"><?= $property['VALUE'] ?></div>
                                 </div>
                                 <?
                             }

                         }

                     }
                  }
                  ?>
               </div>
            </div>

            <div class="tab tab_fed">
               <a href="#" class="mtb" onclick="return false">Отзывы</a>
               <div class="content">

                   <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.comments",
                        ".default",
                        array(
                            "TEMPLATE_THEME" => "blue",
                            "IBLOCK_TYPE" => "1c_catalog",
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "ELEMENT_ID" => $arResult["ID"],
                            "ELEMENT_CODE" => $arResult["CODE"],
                            "URL_TO_COMMENT" => $arResult["DETAIL_PAGE_URL"],
                            "WIDTH" => "",
                            "COMMENTS_COUNT" => "10",
                            "BLOG_USE" => "Y",
                            "FB_USE" => "N",
                            "VK_USE" => "N",
                            "CACHE_TYPE" => "N",
                            "CACHE_TIME" => "0",
                            "BLOG_TITLE" => "Отзывы на товары",
                            "BLOG_URL" => "catalog_comments",
                            "PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
                            "EMAIL_NOTIFY" => "N",
                            "AJAX_POST" => "Y",
                            "SHOW_SPAM" => "N",
                            "SHOW_RATING" => "N",
                            "RATING_TYPE" => "like_graphic",
                            "FB_TITLE" => "Facebook",
                            "FB_USER_ADMIN_ID" => "",
                            "FB_APP_ID" => "",
                            "FB_COLORSCHEME" => "dark",
                            "FB_ORDER_BY" => "time",
                            "VK_TITLE" => "Вконтакте",
                            "VK_API_ID" => "API_ID",
                            "COMPONENT_TEMPLATE" => ".default",
                            "SHOW_DEACTIVATED" => "N"
                        ),
                        false
                    );?>
               </div>
            </div>
            <div class="tab tab_nal active">
               <a href="#" class="mtb" onclick="return false">Наличие в магазинах</a>
               <div class="content">
                  <?$APPLICATION->IncludeComponent(
                    "nbrains:catalog.store.amount",
                    "store",
                    array(
                        "CACHE_TIME" => "36000",
                        "CACHE_TYPE" => "N",
                        "ELEMENT_CODE" => "",
                        "ELEMENT_ID" => $arResult["ID"],
                        "FIELDS" => array(
                            0 => "TITLE",
                            1 => "ADDRESS",
                            2 => "DESCRIPTION",
                            3 => "PHONE",
                            4 => "EMAIL",
                            5 => "IMAGE_ID",
                            6 => "COORDINATES",
                            7 => "SCHEDULE",
                            8 => "",
                        ),
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "IBLOCK_TYPE" => "1c_catalog",
                        "MAIN_TITLE" => "",
                        "MIN_AMOUNT" => "0",
                        "OFFER_ID" => "",
                        "SHOW_EMPTY_STORE" => "N",
                        "SHOW_GENERAL_STORE_INFORMATION" => "N",
                        "STORES" => array(
                            0 => "16",
                        ),
                        "STORE_PATH" => "",
                        "USER_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "USE_MIN_AMOUNT" => "N",
                        "COMPONENT_TEMPLATE" => "store",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO"
                    ),
                    false
                );?>
               </div>
            </div>
         </div>
      </div>
   </div><!--end::pc__prod-info-->



    <?if($arResult['IS_M2']):
        $first_offer = array_shift($arResult['OFFERS']); ?>

     <div class="p-view__param-col p-view__param-col_restyled">

        <div class="p-view__param-box prodcap data-square">

            <div class="b-select_help_new_place">Выберите длину листа и количество штук</div>
            <div class="b-select_help_new_upplace">Внимание! Минимальный заказ 20м2</div>

            <div class="p-view__order-table-wrap">
                <table class="p-view__order-table" id="order-table">
                    <tr class="prod_card_table_fr">
                        <th>длина листа</th>
                        <th>кол-во</th>
                        <th>кол-во м²</th>
                        <th>стоимость</th>
                    </tr>
                    <tr class="order-cnt" data-list="<?=$first_offer['PROPERTIES']['DLINA']['VALUE']?>" data-count="0" data-id="<?=$first_offer['ID']?>" data-idblock="<?=$first_offer['IBLOCK_ID']?>" data-price="<?=$first_offer['MIN_PRICE']['DISCOUNT_VALUE']?>">

                        <td data-toggle="modal" data-target="#available-length" data-item="">
                            <div class="dropdown dropdown_double-icon dropdown-modal">
                                <div class="drop-value"><?=$first_offer['PROPERTIES']['DLINA']['VALUE']?> мм</div>
                            </div>
                        </td>

                        <td>
                            <div class="dropdown dropdown_double-icon">
                                <input name="_quantity" min="0" type="number" style="width: 60px;" placeholder="0 шт" onkeyup="updatePrice(this, $(this).val())" onchange="updatePrice(this, $(this).val())" >
                            </div>
                        </td>
                        <td class="sq">
                            0 м²
                        </td>
                        <td>
                            <span class="price_in-table">0 ₽</span>
                            <button class="no-style p-view__order-table-del" onclick="delRow(this)">&times;</i>
                            </button>
                        </td>
                    </tr>
                </table>

                <button class="no-style button-block p-view__order-table-add">
                    + добавить лист другой длины
                </button>
            </div>



            <input type="hidden" name="width" value="<?=$arResult['PROPERTIES']['SHIRINA_LISTA']['VALUE']?>" >
            <input type="hidden" name="product_id" size="2" value="<?=$arResult['ID']?>" />
            <input type="hidden" name="product_offer_id" id="product_offer_id" value="<?=$arOffers['ID']?>" />

            <? if($arOffers['DISCOUNT_VALUE']): ?>
                <a class="button button-primary button-block text-center toShopBox" id="button-cart-offers" data-toggle="tooltip" data-placement="top" title="необходимо ввести количество">Добавить в корзину</a>
            <?else:?>
                <a href="javascript:void(0)" class="add2cart show-popup" data-id="order-product">Товар под заказ</a>
            <?endif;?>


            <div class="block-fast-buy">
                <p class="err_sucs_text"></p>
                <div class="b-fast-buy">
                    <div class="b-fast-buy-input">
                        <div class="block-input-phone">

                            <input class="forminput" type="text" id="fast-buy-phone-number" placeholder="+7 (___) ___-__-__"  name="fast-buy-phone-number">
                        </div>

                    </div>
                    <div class="b-fast-buy-button">
                        <a class="button button-primary button-block text-center fast-buy-visible" href="javascript://" id="phone-ord-send-button">Перезвоните мне сейчас!</a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>

            <div class="weight-prod">Вес единицы товара: <strong><?=$arResult['PROPERTIES']['VES_M2']['VALUE']?> кг</strong></div>

        </div>

     </div>

    <?else:?>

        <? $APPLICATION->IncludeComponent(
            "bitrix:sale.recommended.products",
            "sale-recomm-product",
            Array(
                "ACTION_VARIABLE" => "action",
                "ADDITIONAL_PICT_PROP_10" => "MORE_PHOTO",
                "ADDITIONAL_PICT_PROP_11" => "MORE_PHOTO",
                "ADDITIONAL_PICT_PROP_12" => "MORE_PHOTO",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "BASKET_URL" => "/personal/basket.php",
                "CACHE_TIME" => "86400",
                "CACHE_TYPE" => "A",
                "CART_PROPERTIES_10" => array("",""),
                "CART_PROPERTIES_11" => array("",""),
                "CART_PROPERTIES_12" => array("",""),
                "CODE" => "",
                "CONVERT_CURRENCY" => "N",
                "DETAIL_URL" => "",
                "HIDE_NOT_AVAILABLE" => "N",
                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                "IBLOCK_TYPE" => "1c_catalog",
                "ID" => $arResult['ID'],
                "LABEL_PROP_10" => "-",
                "LABEL_PROP_11" => "-",
                "LINE_ELEMENT_COUNT" => "3",
                "MESS_BTN_BUY" => "РљСѓРїРёС‚СЊ",
                "MESS_BTN_DETAIL" => "РџРѕРґСЂРѕР±РЅРµРµ",
                "MESS_BTN_SUBSCRIBE" => "РџРѕРґРїРёСЃР°С‚СЊСЃСЏ",
                "MESS_NOT_AVAILABLE" => "РќРµС‚ РІ РЅР°Р»РёС‡РёРё",
                "MIN_BUYES" => "1",
                "OFFER_TREE_PROPS_12" => array(),
                "PAGE_ELEMENT_COUNT" => "30",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array(),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_SUBSCRIPTION" => "N",
                "PROPERTY_CODE_10" => array("",""),
                "PROPERTY_CODE_11" => array("",""),
                "PROPERTY_CODE_12" => array("",""),
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_IMAGE" => "Y",
                "SHOW_NAME" => "Y",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "TEMPLATE_THEME" => "blue",
                "USE_PRODUCT_QUANTITY" => "N",
                "RECOMEND_PRODUCT" => $arResult['PROPERTIES']['RECOMEND_PRODUCT']['VALUE']
            )
        );?>

    <?endif;?>


   <div class="cl"></div>

    <div class="col-show-slides-6">

        <?$APPLICATION->IncludeComponent("bitrix:news.list", "same-product", Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Р¤РѕСЂРјР°С‚ РїРѕРєР°Р·Р° РґР°С‚С‹
            "ADD_SECTIONS_CHAIN" => "N",	// Р’РєР»СЋС‡Р°С‚СЊ СЂР°Р·РґРµР» РІ С†РµРїРѕС‡РєСѓ РЅР°РІРёРіР°С†РёРё
            "AJAX_MODE" => "N",	// Р’РєР»СЋС‡РёС‚СЊ СЂРµР¶РёРј AJAX
            "AJAX_OPTION_ADDITIONAL" => "",	// Р”РѕРїРѕР»РЅРёС‚РµР»СЊРЅС‹Р№ РёРґРµРЅС‚РёС„РёРєР°С‚РѕСЂ
            "AJAX_OPTION_HISTORY" => "N",	// Р’РєР»СЋС‡РёС‚СЊ СЌРјСѓР»СЏС†РёСЋ РЅР°РІРёРіР°С†РёРё Р±СЂР°СѓР·РµСЂР°
            "AJAX_OPTION_JUMP" => "N",	// Р’РєР»СЋС‡РёС‚СЊ РїСЂРѕРєСЂСѓС‚РєСѓ Рє РЅР°С‡Р°Р»Сѓ РєРѕРјРїРѕРЅРµРЅС‚Р°
            "AJAX_OPTION_STYLE" => "Y",	// Р’РєР»СЋС‡РёС‚СЊ РїРѕРґРіСЂСѓР·РєСѓ СЃС‚РёР»РµР№
            "CACHE_FILTER" => "N",	// РљРµС€РёСЂРѕРІР°С‚СЊ РїСЂРё СѓСЃС‚Р°РЅРѕРІР»РµРЅРЅРѕРј С„РёР»СЊС‚СЂРµ
            "CACHE_GROUPS" => "Y",	// РЈС‡РёС‚С‹РІР°С‚СЊ РїСЂР°РІР° РґРѕСЃС‚СѓРїР°
            "CACHE_TIME" => "36000000",	// Р’СЂРµРјСЏ РєРµС€РёСЂРѕРІР°РЅРёСЏ (СЃРµРє.)
            "CACHE_TYPE" => "A",	// РўРёРї РєРµС€РёСЂРѕРІР°РЅРёСЏ
            "CHECK_DATES" => "Y",	// РџРѕРєР°Р·С‹РІР°С‚СЊ С‚РѕР»СЊРєРѕ Р°РєС‚РёРІРЅС‹Рµ РЅР° РґР°РЅРЅС‹Р№ РјРѕРјРµРЅС‚ СЌР»РµРјРµРЅС‚С‹
            "DETAIL_URL" => "",	// URL СЃС‚СЂР°РЅРёС†С‹ РґРµС‚Р°Р»СЊРЅРѕРіРѕ РїСЂРѕСЃРјРѕС‚СЂР° (РїРѕ СѓРјРѕР»С‡Р°РЅРёСЋ - РёР· РЅР°СЃС‚СЂРѕРµРє РёРЅС„РѕР±Р»РѕРєР°)
            "DISPLAY_BOTTOM_PAGER" => "Y",	// Р’С‹РІРѕРґРёС‚СЊ РїРѕРґ СЃРїРёСЃРєРѕРј
            "DISPLAY_DATE" => "Y",	// Р’С‹РІРѕРґРёС‚СЊ РґР°С‚Сѓ СЌР»РµРјРµРЅС‚Р°
            "DISPLAY_NAME" => "Y",	// Р’С‹РІРѕРґРёС‚СЊ РЅР°Р·РІР°РЅРёРµ СЌР»РµРјРµРЅС‚Р°
            "DISPLAY_PICTURE" => "Y",	// Р’С‹РІРѕРґРёС‚СЊ РёР·РѕР±СЂР°Р¶РµРЅРёРµ РґР»СЏ Р°РЅРѕРЅСЃР°
            "DISPLAY_PREVIEW_TEXT" => "Y",	// Р’С‹РІРѕРґРёС‚СЊ С‚РµРєСЃС‚ Р°РЅРѕРЅСЃР°
            "DISPLAY_TOP_PAGER" => "N",	// Р’С‹РІРѕРґРёС‚СЊ РЅР°Рґ СЃРїРёСЃРєРѕРј
            "FIELD_CODE" => array(	// РџРѕР»СЏ
                0 => "",
                1 => "",
            ),
            "FILTER_NAME" => "",	// Р¤РёР»СЊС‚СЂ
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// РЎРєСЂС‹РІР°С‚СЊ СЃСЃС‹Р»РєСѓ, РµСЃР»Рё РЅРµС‚ РґРµС‚Р°Р»СЊРЅРѕРіРѕ РѕРїРёСЃР°РЅРёСЏ
            "IBLOCK_ID" => $arResult['IBLOCK_ID'],	// РљРѕРґ РёРЅС„РѕСЂРјР°С†РёРѕРЅРЅРѕРіРѕ Р±Р»РѕРєР°
            "IBLOCK_TYPE" => "1c_catalog",	// РўРёРї РёРЅС„РѕСЂРјР°С†РёРѕРЅРЅРѕРіРѕ Р±Р»РѕРєР° (РёСЃРїРѕР»СЊР·СѓРµС‚СЃСЏ С‚РѕР»СЊРєРѕ РґР»СЏ РїСЂРѕРІРµСЂРєРё)
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Р’РєР»СЋС‡Р°С‚СЊ РёРЅС„РѕР±Р»РѕРє РІ С†РµРїРѕС‡РєСѓ РЅР°РІРёРіР°С†РёРё
            "INCLUDE_SUBSECTIONS" => "Y",	// РџРѕРєР°Р·С‹РІР°С‚СЊ СЌР»РµРјРµРЅС‚С‹ РїРѕРґСЂР°Р·РґРµР»РѕРІ СЂР°Р·РґРµР»Р°
            "MESSAGE_404" => "",	// РЎРѕРѕР±С‰РµРЅРёРµ РґР»СЏ РїРѕРєР°Р·Р° (РїРѕ СѓРјРѕР»С‡Р°РЅРёСЋ РёР· РєРѕРјРїРѕРЅРµРЅС‚Р°)
            "NEWS_COUNT" => "20",	// РљРѕР»РёС‡РµСЃС‚РІРѕ РЅРѕРІРѕСЃС‚РµР№ РЅР° СЃС‚СЂР°РЅРёС†Рµ
            "PAGER_BASE_LINK_ENABLE" => "N",	// Р’РєР»СЋС‡РёС‚СЊ РѕР±СЂР°Р±РѕС‚РєСѓ СЃСЃС‹Р»РѕРє
            "PAGER_DESC_NUMBERING" => "N",	// Р�СЃРїРѕР»СЊР·РѕРІР°С‚СЊ РѕР±СЂР°С‚РЅСѓСЋ РЅР°РІРёРіР°С†РёСЋ
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Р’СЂРµРјСЏ РєРµС€РёСЂРѕРІР°РЅРёСЏ СЃС‚СЂР°РЅРёС† РґР»СЏ РѕР±СЂР°С‚РЅРѕР№ РЅР°РІРёРіР°С†РёРё
            "PAGER_SHOW_ALL" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ СЃСЃС‹Р»РєСѓ "Р’СЃРµ"
            "PAGER_SHOW_ALWAYS" => "N",	// Р’С‹РІРѕРґРёС‚СЊ РІСЃРµРіРґР°
            "PAGER_TEMPLATE" => ".default",	// РЁР°Р±Р»РѕРЅ РїРѕСЃС‚СЂР°РЅРёС‡РЅРѕР№ РЅР°РІРёРіР°С†РёРё
            "PAGER_TITLE" => "Товары со схожими характеристиками",	// РќР°Р·РІР°РЅРёРµ РєР°С‚РµРіРѕСЂРёР№
            "PARENT_SECTION" => $arResult['IBLOCK_SECTION_ID'],	// ID СЂР°Р·РґРµР»Р°
            "PARENT_SECTION_CODE" => "",	// РљРѕРґ СЂР°Р·РґРµР»Р°
            "PREVIEW_TRUNCATE_LEN" => "",	// РњР°РєСЃРёРјР°Р»СЊРЅР°СЏ РґР»РёРЅР° Р°РЅРѕРЅСЃР° РґР»СЏ РІС‹РІРѕРґР° (С‚РѕР»СЊРєРѕ РґР»СЏ С‚РёРїР° С‚РµРєСЃС‚)
            "PROPERTY_CODE" => array(	// РЎРІРѕР№СЃС‚РІР°
                0 => "",
                1 => "CML2_BASE_UNIT",
            ),
            "SET_BROWSER_TITLE" => "Y",	// РЈСЃС‚Р°РЅР°РІР»РёРІР°С‚СЊ Р·Р°РіРѕР»РѕРІРѕРє РѕРєРЅР° Р±СЂР°СѓР·РµСЂР°
            "SET_LAST_MODIFIED" => "N",	// РЈСЃС‚Р°РЅР°РІР»РёРІР°С‚СЊ РІ Р·Р°РіРѕР»РѕРІРєР°С… РѕС‚РІРµС‚Р° РІСЂРµРјСЏ РјРѕРґРёС„РёРєР°С†РёРё СЃС‚СЂР°РЅРёС†С‹
            "SET_META_DESCRIPTION" => "N",	// РЈСЃС‚Р°РЅР°РІР»РёРІР°С‚СЊ РѕРїРёСЃР°РЅРёРµ СЃС‚СЂР°РЅРёС†С‹
            "SET_META_KEYWORDS" => "N",	// РЈСЃС‚Р°РЅР°РІР»РёРІР°С‚СЊ РєР»СЋС‡РµРІС‹Рµ СЃР»РѕРІР° СЃС‚СЂР°РЅРёС†С‹
            "SET_STATUS_404" => "N",	// РЈСЃС‚Р°РЅР°РІР»РёРІР°С‚СЊ СЃС‚Р°С‚СѓСЃ 404
            "SET_TITLE" => "N",	// РЈСЃС‚Р°РЅР°РІР»РёРІР°С‚СЊ Р·Р°РіРѕР»РѕРІРѕРє СЃС‚СЂР°РЅРёС†С‹
            "SHOW_404" => "N",	// РџРѕРєР°Р· СЃРїРµС†РёР°Р»СЊРЅРѕР№ СЃС‚СЂР°РЅРёС†С‹
            "SORT_BY1" => "ACTIVE_FROM",	// РџРѕР»Рµ РґР»СЏ РїРµСЂРІРѕР№ СЃРѕСЂС‚РёСЂРѕРІРєРё РЅРѕРІРѕСЃС‚РµР№
            "SORT_BY2" => "SORT",	// РџРѕР»Рµ РґР»СЏ РІС‚РѕСЂРѕР№ СЃРѕСЂС‚РёСЂРѕРІРєРё РЅРѕРІРѕСЃС‚РµР№
            "SORT_ORDER1" => "DESC",	// РќР°РїСЂР°РІР»РµРЅРёРµ РґР»СЏ РїРµСЂРІРѕР№ СЃРѕСЂС‚РёСЂРѕРІРєРё РЅРѕРІРѕСЃС‚РµР№
            "SORT_ORDER2" => "ASC",	// РќР°РїСЂР°РІР»РµРЅРёРµ РґР»СЏ РІС‚РѕСЂРѕР№ СЃРѕСЂС‚РёСЂРѕРІРєРё РЅРѕРІРѕСЃС‚РµР№
            "STRICT_SECTION_CHECK" => "N",	// РЎС‚СЂРѕРіР°СЏ РїСЂРѕРІРµСЂРєР° СЂР°Р·РґРµР»Р° РґР»СЏ РїРѕРєР°Р·Р° СЃРїРёСЃРєР°
        ),
            false
        );?>

        <?$APPLICATION->IncludeComponent("bitrix:catalog.products.viewed", "products-viewed", Array(
            "ACTION_VARIABLE" => "action_cpv",	// РќР°Р·РІР°РЅРёРµ РїРµСЂРµРјРµРЅРЅРѕР№, РІ РєРѕС‚РѕСЂРѕР№ РїРµСЂРµРґР°РµС‚СЃСЏ РґРµР№СЃС‚РІРёРµ
            "ADDITIONAL_PICT_PROP_10" => "-",
            "ADDITIONAL_PICT_PROP_11" => "-",	// Р”РѕРїРѕР»РЅРёС‚РµР»СЊРЅР°СЏ РєР°СЂС‚РёРЅРєР°
            "ADDITIONAL_PICT_PROP_12" => "-",	// Р”РѕРїРѕР»РЅРёС‚РµР»СЊРЅР°СЏ РєР°СЂС‚РёРЅРєР°
            "ADD_PROPERTIES_TO_BASKET" => "Y",	// Р”РѕР±Р°РІР»СЏС‚СЊ РІ РєРѕСЂР·РёРЅСѓ СЃРІРѕР№СЃС‚РІР° С‚РѕРІР°СЂРѕРІ Рё РїСЂРµРґР»РѕР¶РµРЅРёР№
            "ADD_TO_BASKET_ACTION" => "ADD",	// РџРѕРєР°Р·С‹РІР°С‚СЊ РєРЅРѕРїРєСѓ РґРѕР±Р°РІР»РµРЅРёСЏ РІ РєРѕСЂР·РёРЅСѓ РёР»Рё РїРѕРєСѓРїРєРё
            "BASKET_URL" => "/personal/basket.php",	// URL, РІРµРґСѓС‰РёР№ РЅР° СЃС‚СЂР°РЅРёС†Сѓ СЃ РєРѕСЂР·РёРЅРѕР№ РїРѕРєСѓРїР°С‚РµР»СЏ
            "CACHE_GROUPS" => "Y",	// РЈС‡РёС‚С‹РІР°С‚СЊ РїСЂР°РІР° РґРѕСЃС‚СѓРїР°
            "CACHE_TIME" => "3600",	// Р’СЂРµРјСЏ РєРµС€РёСЂРѕРІР°РЅРёСЏ (СЃРµРє.)
            "CACHE_TYPE" => "A",	// РўРёРї РєРµС€РёСЂРѕРІР°РЅРёСЏ
            "CART_PROPERTIES_10" => array(
                0 => "",
                1 => "",
            ),
            "CART_PROPERTIES_11" => array(	// РЎРІРѕР№СЃС‚РІР° РґР»СЏ РґРѕР±Р°РІР»РµРЅРёСЏ РІ РєРѕСЂР·РёРЅСѓ
                0 => "",
                1 => "",
            ),
            "CART_PROPERTIES_12" => array(	// РЎРІРѕР№СЃС‚РІР° РґР»СЏ РґРѕР±Р°РІР»РµРЅРёСЏ РІ РєРѕСЂР·РёРЅСѓ
                0 => "",
                1 => "",
            ),
            "CONVERT_CURRENCY" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ С†РµРЅС‹ РІ РѕРґРЅРѕР№ РІР°Р»СЋС‚Рµ
            "DEPTH" => "2",	// РњР°РєСЃРёРјР°Р»СЊРЅР°СЏ РѕС‚РѕР±СЂР°Р¶Р°РµРјР°СЏ РіР»СѓР±РёРЅР° СЂР°Р·РґРµР»РѕРІ
            "DISPLAY_COMPARE" => "N",	// Р Р°Р·СЂРµС€РёС‚СЊ СЃСЂР°РІРЅРµРЅРёРµ С‚РѕРІР°СЂРѕРІ
            "ENLARGE_PRODUCT" => "STRICT",	// Р’С‹РґРµР»СЏС‚СЊ С‚РѕРІР°СЂС‹ РІ СЃРїРёСЃРєРµ
            "HIDE_NOT_AVAILABLE" => "N",	// РќРµ РѕС‚РѕР±СЂР°Р¶Р°С‚СЊ С‚РѕРІР°СЂС‹, РєРѕС‚РѕСЂС‹С… РЅРµС‚ РЅР° СЃРєР»Р°РґР°С…
            "HIDE_NOT_AVAILABLE_OFFERS" => "N",	// РўРѕСЂРіРѕРІС‹Рµ РїСЂРµРґР»РѕР¶РµРЅРёСЏ, РЅРµРґРѕСЃС‚СѓРїРЅС‹Рµ РґР»СЏ РїРѕРєСѓРїРєРё
            "IBLOCK_ID" => $arParams['IBLOCK_ID'],	// Р?РЅС„РѕР±Р»РѕРє
            "IBLOCK_MODE" => "single",	// РџРѕРєР°Р·С‹РІР°С‚СЊ С‚РѕРІР°СЂС‹ РёР·
            "IBLOCK_TYPE" => "1c_catalog",	// РўРёРї РёРЅС„РѕР±Р»РѕРєР°
            "LABEL_PROP_10" => "",
            "LABEL_PROP_11" => "",	// РЎРІРѕР№СЃС‚РІРѕ РјРµС‚РѕРє С‚РѕРІР°СЂР°
            "LABEL_PROP_POSITION" => "top-left",	// Р Р°СЃРїРѕР»РѕР¶РµРЅРёРµ РјРµС‚РѕРє С‚РѕРІР°СЂР°
            "MESS_BTN_ADD_TO_BASKET" => "Р’ РєРѕСЂР·РёРЅСѓ",	// РўРµРєСЃС‚ РєРЅРѕРїРєРё "Р”РѕР±Р°РІРёС‚СЊ РІ РєРѕСЂР·РёРЅСѓ"
            "MESS_BTN_BUY" => "РљСѓРїРёС‚СЊ",	// РўРµРєСЃС‚ РєРЅРѕРїРєРё "РљСѓРїРёС‚СЊ"
            "MESS_BTN_DETAIL" => "РџРѕРґСЂРѕР±РЅРµРµ",	// РўРµРєСЃС‚ РєРЅРѕРїРєРё "РџРѕРґСЂРѕР±РЅРµРµ"
            "MESS_BTN_SUBSCRIBE" => "РџРѕРґРїРёСЃР°С‚СЊСЃСЏ",	// РўРµРєСЃС‚ РєРЅРѕРїРєРё "РЈРІРµРґРѕРјРёС‚СЊ Рѕ РїРѕСЃС‚СѓРїР»РµРЅРёРё"
            "MESS_NOT_AVAILABLE" => "РќРµС‚ РІ РЅР°Р»РёС‡РёРё",	// РЎРѕРѕР±С‰РµРЅРёРµ РѕР± РѕС‚СЃСѓС‚СЃС‚РІРёРё С‚РѕРІР°СЂР°
            "OFFER_TREE_PROPS_12" => "",	// РЎРІРѕР№СЃС‚РІР° РґР»СЏ РіСЂСѓРїРїРёСЂРѕРІРєРё
            "PAGE_ELEMENT_COUNT" => "9",	// РљРѕР»РёС‡РµСЃС‚РІРѕ СЌР»РµРјРµРЅС‚РѕРІ РЅР° СЃС‚СЂР°РЅРёС†Рµ
            "PARTIAL_PRODUCT_PROPERTIES" => "N",	// Р Р°Р·СЂРµС€РёС‚СЊ РґРѕР±Р°РІР»СЏС‚СЊ РІ РєРѕСЂР·РёРЅСѓ С‚РѕРІР°СЂС‹, Сѓ РєРѕС‚РѕСЂС‹С… Р·Р°РїРѕР»РЅРµРЅС‹ РЅРµ РІСЃРµ С…Р°СЂР°РєС‚РµСЂРёСЃС‚РёРєРё
            "PRICE_CODE" => "",	// РўРёРї С†РµРЅС‹
            "PRICE_VAT_INCLUDE" => "Y",	// Р’РєР»СЋС‡Р°С‚СЊ РќР”РЎ РІ С†РµРЅСѓ
            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",	// РџРѕСЂСЏРґРѕРє РѕС‚РѕР±СЂР°Р¶РµРЅРёСЏ Р±Р»РѕРєРѕРІ С‚РѕРІР°СЂР°
            "PRODUCT_ID_VARIABLE" => "id",	// РќР°Р·РІР°РЅРёРµ РїРµСЂРµРјРµРЅРЅРѕР№, РІ РєРѕС‚РѕСЂРѕР№ РїРµСЂРµРґР°РµС‚СЃСЏ РєРѕРґ С‚РѕРІР°СЂР° РґР»СЏ РїРѕРєСѓРїРєРё
            "PRODUCT_PROPS_VARIABLE" => "prop",	// РќР°Р·РІР°РЅРёРµ РїРµСЂРµРјРµРЅРЅРѕР№, РІ РєРѕС‚РѕСЂРѕР№ РїРµСЂРµРґР°СЋС‚СЃСЏ С…Р°СЂР°РєС‚РµСЂРёСЃС‚РёРєРё С‚РѕРІР°СЂР°
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",	// РќР°Р·РІР°РЅРёРµ РїРµСЂРµРјРµРЅРЅРѕР№, РІ РєРѕС‚РѕСЂРѕР№ РїРµСЂРµРґР°РµС‚СЃСЏ РєРѕР»РёС‡РµСЃС‚РІРѕ С‚РѕРІР°СЂР°
            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",	// Р’Р°СЂРёР°РЅС‚ РѕС‚РѕР±СЂР°Р¶РµРЅРёСЏ С‚РѕРІР°СЂРѕРІ
            "PRODUCT_SUBSCRIPTION" => "Y",	// Р Р°Р·СЂРµС€РёС‚СЊ РѕРїРѕРІРµС‰РµРЅРёСЏ РґР»СЏ РѕС‚СЃСѓС‚СЃС‚РІСѓСЋС‰РёС… С‚РѕРІР°СЂРѕРІ
            "PROPERTY_CODE_10" => array(
                0 => "",
                1 => "",
            ),
            "PROPERTY_CODE_11" => array(	// РЎРІРѕР№СЃС‚РІР° РґР»СЏ РѕС‚РѕР±СЂР°Р¶РµРЅРёСЏ
                0 => "",
                1 => "",
            ),
            "PROPERTY_CODE_12" => array(	// РЎРІРѕР№СЃС‚РІР° РґР»СЏ РѕС‚РѕР±СЂР°Р¶РµРЅРёСЏ
                0 => "",
                1 => "",
            ),
            "PROPERTY_CODE_MOBILE_11" => "",	// РЎРІРѕР№СЃС‚РІР° С‚РѕРІР°СЂРѕРІ, РѕС‚РѕР±СЂР°Р¶Р°РµРјС‹Рµ РЅР° РјРѕР±РёР»СЊРЅС‹С… СѓСЃС‚СЂРѕР№СЃС‚РІР°С…
            "SECTION_CODE" => "",	// РљРѕРґ СЂР°Р·РґРµР»Р°
            "SECTION_ELEMENT_CODE" => "",	// РЎРёРјРІРѕР»СЊРЅС‹Р№ РєРѕРґ СЌР»РµРјРµРЅС‚Р°, РґР»СЏ РєРѕС‚РѕСЂРѕРіРѕ Р±СѓРґРµС‚ РІС‹Р±СЂР°РЅ СЂР°Р·РґРµР»
            "SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],	// ID СЌР»РµРјРµРЅС‚Р°, РґР»СЏ РєРѕС‚РѕСЂРѕРіРѕ Р±СѓРґРµС‚ РІС‹Р±СЂР°РЅ СЂР°Р·РґРµР»
            "SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],	// ID СЂР°Р·РґРµР»Р°
            "SHOW_CLOSE_POPUP" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ РєРЅРѕРїРєСѓ РїСЂРѕРґРѕР»Р¶РµРЅРёСЏ РїРѕРєСѓРїРѕРє РІРѕ РІСЃРїР»С‹РІР°СЋС‰РёС… РѕРєРЅР°С…
            "SHOW_DISCOUNT_PERCENT" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ РїСЂРѕС†РµРЅС‚ СЃРєРёРґРєРё
            "SHOW_FROM_SECTION" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ С‚РѕРІР°СЂС‹ РёР· СЂР°Р·РґРµР»Р°
            "SHOW_MAX_QUANTITY" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ РѕСЃС‚Р°С‚РѕРє С‚РѕРІР°СЂР°
            "SHOW_OLD_PRICE" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ СЃС‚Р°СЂСѓСЋ С†РµРЅСѓ
            "SHOW_PRICE_COUNT" => "1",	// Р’С‹РІРѕРґРёС‚СЊ С†РµРЅС‹ РґР»СЏ РєРѕР»РёС‡РµСЃС‚РІР°
            "SHOW_PRODUCTS_10" => "N",
            "SHOW_PRODUCTS_11" => "N",
            "SHOW_SLIDER" => "N",	// РџРѕРєР°Р·С‹РІР°С‚СЊ СЃР»Р°Р№РґРµСЂ РґР»СЏ С‚РѕРІР°СЂРѕРІ
            "SLIDER_INTERVAL" => "3000",
            "SLIDER_PROGRESS" => "N",
            "TEMPLATE_THEME" => "blue",	// Р¦РІРµС‚РѕРІР°СЏ С‚РµРјР°
            "USE_ENHANCED_ECOMMERCE" => "N",	// РћС‚РїСЂР°РІР»СЏС‚СЊ РґР°РЅРЅС‹Рµ СЌР»РµРєС‚СЂРѕРЅРЅРѕР№ С‚РѕСЂРіРѕРІР»Рё РІ Google Рё РЇРЅРґРµРєСЃ
            "USE_PRICE_COUNT" => "N",	// Р?СЃРїРѕР»СЊР·РѕРІР°С‚СЊ РІС‹РІРѕРґ С†РµРЅ СЃ РґРёР°РїР°Р·РѕРЅР°РјРё
            "USE_PRODUCT_QUANTITY" => "N",	// Р Р°Р·СЂРµС€РёС‚СЊ СѓРєР°Р·Р°РЅРёРµ РєРѕР»РёС‡РµСЃС‚РІР° С‚РѕРІР°СЂР°
            "COMPONENT_TEMPLATE" => ".default",
            "SET_VIEWED_IN_COMPONENT" => "Y"
        ),
            false
        );?>


    </div>


</div><!--end::prod_card-->

<?if($arResult['IS_M2']):?>
<!-- Modal -->
<div class="modal fade  bs-example-modal-lg" id="available-length" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Доступные длины (мм)</h4>
                <h4>Выберите необходимую длину.</h4>
            </div>
            <div class="modal-body">
                <span style="margin-bottom: 20px;display: block">
                    <img src="<?=$this->GetFolder()?>/images/popularlength.png" style="position: relative;">
                     - Размеры в наличии.
                </span>
                <div class="table-responsive">
                    <table class="table table-bordered" id="av-length-table">
                        <?
                        $leng_count = count($arResult['OFFERS_TABLE']);
                        for($i = 0; $i <= $leng_count; $i++):
                        ?>
                            <tr>
                            <?foreach($arResult['OFFERS_TABLE'][$i] as $id => $width):?>
                                    <td
                                        class=""
                                        data-id="<?=$width['ID']?>"
                                        data-idblock="<?=$width['IBLOCK_ID']?>"
                                        data-price="<?=$width['MIN_PRICE']['DISCOUNT_VALUE']?>"
                                        <?if($width['CATALOG_QUANTITY']):?> style="color: green; background: #C1EFB1" <?endif;?>
                                        >
                                        <?=$width['PROPERTIES']['DLINA']['VALUE'];?>
                                    </td>
                            <? endforeach; ?>
                            </tr>
                        <? endfor; ?>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>
<? endif; ?>
