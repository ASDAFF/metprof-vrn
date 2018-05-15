<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бесплатный замер");
?><div class="row cl">
	<div class="rq__form">
		<p>
			Наши специалисты помогут Вам избежать ошибок и произвести правильный замер кровли, фасада. Для этого мы осуществляем бесплатный выезд на Ваш объект.
		</p>
		 <?$APPLICATION->IncludeComponent(
	"nbrains:main.feedback",
	"free-calc",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"EMAIL_TO" => "info@metprof-vrn.ru",
		"EVENT_MESSAGE_ID" => array(0=>"88",),
		"IBLOCK_ID" => "31",
		"IBLOCK_TYPE" => "feedback",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"PROPERTY_CODE" => array(0=>"FIO",1=>"EMAIL",2=>"PHONE",3=>"TIME_AFTER",4=>"DESC",5=>"RULE",6=>"FILE",),
		"REQUIRED_FIELDS" => "",
		"USE_CAPTCHA" => "N"
	)
);?>
	</div>
	<div class="rq__list">
		<div class="title">
			Обратившись в нашу компанию Вы получите:
		</div>
		<ul>
			<li>Бесплатную консультацию по выбору и правильной комплектации кровельными и фасадными материалами;</li>
			<li>Квалифицированный подбор и расчет продукции под Ваши потребности;</li>
			<li>Рекомендации по хранению и монтажу.</li>
		</ul>
	</div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>