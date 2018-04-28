<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бесплатный расчёт");
?>

<div class="row cl">
    <div class="rq__form">
    <p>Наши сотрудники помогут Вам правильно скомплектовать Ваш заказ, избежать стандартных ошибок и как следствие сэкономить время и деньги.</p>


        <?$APPLICATION->IncludeComponent("nbrains:main.feedback", "free-calc", Array(
            "COMPONENT_TEMPLATE" => ".default",
            "EMAIL_TO" => "info@metprof-vrn.ru",	// E-mail, на который будет отправлено письмо
            "EVENT_MESSAGE_ID" => array(	// Почтовые шаблоны для отправки письма
                0 => "88",
            ),
            "IBLOCK_ID" => "13",	// Код информационного блока
            "IBLOCK_TYPE" => "feedback",	// Тип информационного блока (используется только для проверки)
            "OK_TEXT" => "Спасибо, ваше сообщение принято.",	// Сообщение, выводимое пользователю после отправки
            "PROPERTY_CODE" => array(	// Поля формы
                0 => "FIO",
                1 => "EMAIL",
                2 => "PHONE",
                3 => "TIME_AFTER",
                4 => "DESC",
                5 => "RULE",
                6 => "FILE",
            ),
            "REQUIRED_FIELDS" => "",
            "USE_CAPTCHA" => "N",	// Использовать защиту от автоматических сообщений (CAPTCHA) для неавторизованных пользователей
        ),
            false
        );?>

    </div>

        <div class="rq__list">
            <div class="title">Обратившись в нашу компанию Вы получите:</div>
            <ul>
                <li>Бесплатную консультацию по выбору и правильной комплектации кровельными и фасадными материалами;</li>
                <li>Квалифицированный подбор и расчет продукции под Ваши потребности;</li>
                <li>Рекомендации по хранению и монтажу.</li>
            </ul>
        </div>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>