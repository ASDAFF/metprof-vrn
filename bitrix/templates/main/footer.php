				<?if(!$is_main && $pages[1] !== 'basket' && !($pages[1] == 'catalog' && $pages[3])){?>
				</div><!--end::page_content-->
				<?}?>
				<footer>

					<div class="footer__top cl">
						<div class="footer__col col--1">
							<a href="/" class="footer__logo">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/h_logo.jpg" alt="Полимер" width="206" height="44">
							</a>
							<p class="footer__logotext">Оптово-розничная торговля материалами и оборудованием для отопления и водоснабжения в Воронежской области.</p>
						</div><!--end::col__1-->
						<div class="footer__col col--2">
							<div class="footer__title">Контакты</div>
							<ul class="footer__list cl">
								<li><?= tplvar('phone_bottom_one', true);?></li>
								<li><?= tplvar('phone_bottom_two', true);?></li>
								<li><a href="/contacts/">Адреса магазинов</a>
							</li>
							</ul>
						</div><!--end::col__2-->
						<div class="footer__col col--3">
							<div class="footer__title">Компания</div>
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"footer-about", 
								array(
									"ALLOW_MULTI_SELECT" => "N",
									"CHILD_MENU_TYPE" => "top",
									"DELAY" => "N",
									"MAX_LEVEL" => "1",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"ROOT_MENU_TYPE" => "top",
									"USE_EXT" => "N",
									"COMPONENT_TEMPLATE" => "footer-about"
								),
								false
							); //footer__list  footer__list--50?>
						</div><!--end::col__3-->
						<div class="footer__col col--4">
							<div class="footer__title">Каталог</div>
							<div class="cl">
								<ul class="footer__list footer__list--50">
									<li><a href="/catalog/inzhenernaya_santekhnika_otoplenie_vodoprovod_kanalizatsiya/">Инженерная сантехника</a></li>
									<li><a href="/catalog/stroitelnye_materialy/">Строительные материалы</a></li>
								</ul>
							</div>
							<?
							/*
							$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"footer-catalog", 
								array(
									"ALLOW_MULTI_SELECT" => "N",
									"CHILD_MENU_TYPE" => "footer",
									"DELAY" => "N",
									"MAX_LEVEL" => "1",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"ROOT_MENU_TYPE" => "footer_catalog",
									"USE_EXT" => "N",
									"COMPONENT_TEMPLATE" => "footer"
								),
								false
							); //footer__list */?>
						</div>
					</div>
					<div class="footer__bottom cl">
						<div class="footer__copyright">© 2006 — <?=date("Y");?>. Полимер.</div>
						<ul class="footer__pay pay" title="Все способы оплаты">
							<li><a href="javascript:void(0)" class="visa">Visa</a></li>
							<li><a href="javascript:void(0)" class="master">MasterCard</a></li>
							<li><a href="javascript:void(0)" class="qiwi">Qiwi</a></li>
							<li><a href="javascript:void(0)" class="webmoney">Webmoney</a></li>
							<li><a href="javascript:void(0)" class="ya">Яндекс Деньги</a></li>
						</ul>
						<div class="footer__studio">


						</div>
					</div>
				</footer>
			</div><!--end::wr-->
     	</div><!--end::container-->


				<!— BEGIN JIVOSITE CODE {literal} —>
				<script type='text/javascript'>
					(function(){ var widget_id = 'Ms4VnpNIHY';var d=document;var w=window;function l(){
						var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
				</script>
				<!— {/literal} END JIVOSITE CODE —>

<!-- Yandex.Metrika counter Prime -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter29722775 = new Ya.Metrika({
                    id:29722775,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/29722775" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Yandex.Metrika counter Веброст -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter45640992 = new Ya.Metrika({
                    id:45640992,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    ecommerce:"dataLayer"
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/45640992" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


			<?$APPLICATION->IncludeComponent(
	"nbrains:main.feedback", 
	"order-product", 
	array(
		"EMAIL_TO" => "sale@polimer-vrn",
		"EVENT_MESSAGE_ID" => array(
			0 => "103",
		),
		"IBLOCK_ID" => "18",
		"IBLOCK_TYPE" => "feedback",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"PROPERTY_CODE" => array(
			0 => "EMAIL",
			1 => "PHONE",
			2 => "FIO",
			3 => "PRODUCT",
			4 => "LINK_PRODUCT",
			5 => "RULE",
		),
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "order-product",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>

			<?$APPLICATION->IncludeComponent(
	"nbrains:main.feedback", 
	"write-mail", 
	array(
		"EMAIL_TO" => "sale@polimer-vrn",
		"EVENT_MESSAGE_ID" => array(
			0 => "92",
		),
		"IBLOCK_ID" => "14",
		"IBLOCK_TYPE" => "feedback",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"PROPERTY_CODE" => array(
			0 => "FIO",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "DESC",
			4 => "RULE",
		),
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "write-mail"
	),
	false
);?>

				<?
				$arResult = getUrlProd($APPLICATION->GetCurPage(false));
				if(CFile::GetPath($arResult['MORE_PHOTO']['VALUE'][0])){
					$img = CFile::GetPath($arResult['MORE_PHOTO']['VALUE'][0]);
				}else{
					$img = CFile::GetPath($arResult['DETAIL_PICTURE']);
				}
				$APPLICATION->IncludeComponent(
					"nbrains:main.feedback",
					"buy-one-click",
					array(
						"EMAIL_TO" => "sale@polimer-vrn",
						"EVENT_MESSAGE_ID" => array(
							0 => "90",
						),
						"IBLOCK_ID" => "15",
						"IBLOCK_TYPE" => "feedback",
						"OK_TEXT" => "Спасибо, ваше сообщение принято.",
						"PROPERTY_CODE" => array(
							0 => "FIO",
							1 => "PHONE",
							2 => "EMAIL",
							3 => "RULE",
							4 => "PRODUCT",
							5 => "LINK_PRODUCT",
							6 => "IMG_PRODUCT",
							7 => "PRICE",
						),
						"USE_CAPTCHA" => "N",
						"COMPONENT_TEMPLATE" => "buy-one-click",
						"PRODUCT" => array(
							"NAME" => $arResult['NAME'],
							"LINK" => $arResult['DETAIL_PAGE_URL'],
							"IMG" => $img,
							"PRICE" => priceDiscount($arResult['ID']),
						)
					),
					false
				);?>

				<?$APPLICATION->IncludeComponent(
	"nbrains:main.feedback", 
	"buy-one-click-cart", 
	array(
		"EMAIL_TO" => "sale@polimer-vrn",
		"EVENT_MESSAGE_ID" => array(
			0 => "104",
		),
		"IBLOCK_ID" => "23",
		"IBLOCK_TYPE" => "feedback",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"PROPERTY_CODE" => array(
			0 => "FIO",
			1 => "EMAIL",
			2 => "PHONE",
			3 => "RULE",
			4 => "PRODUCT_CART",
		),
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "buy-one-click-cart"
	),
	false
);?>

				<?$APPLICATION->IncludeComponent(
	"nbrains:main.feedback", 
	"free-consultant", 
	array(
		"EMAIL_TO" => "sale@polimer-vrn",
		"EVENT_MESSAGE_ID" => array(
			0 => "91",
		),
		"IBLOCK_ID" => "16",
		"IBLOCK_TYPE" => "feedback",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"PROPERTY_CODE" => array(
			0 => "FIO",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "RULE",
			4 => "PRODUCT",
			5 => "LINK_PRODUCT",
		),
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "free-consultant"
	),
	false
);?>


	</body>
</html>