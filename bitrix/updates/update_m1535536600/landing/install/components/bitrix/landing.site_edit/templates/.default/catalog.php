<?php
namespace Bitrix\Landing\Components\LandingEdit;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/** @var array $arResult */
/** @var array $arParams */
/** @var \CMain $APPLICATION */

use \Bitrix\Landing\Manager;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__DIR__ . '/template.php');
\Bitrix\Main\UI\Extension::load('ui.buttons');
\CJSCore::init(array('landing_master'));

if ($arResult['ERRORS'])
{
	?><div class="landing-message-label error"><?
	foreach ($arResult['ERRORS'] as $error)
	{
		echo $error . '<br/>';
	}
	?></div><?
}
if ($arResult['FATAL'])
{
	return;
}

// vars
$domains = $arResult['DOMAINS'];
$row = $arResult['SITE'];
$hooks = $arResult['HOOKS'];
$request = \bitrix\Main\HttpContext::getCurrent()->getRequest();

// title
$APPLICATION->setTitle(Loc::getMessage('LANDING_TPL_TITLE_EDIT_CATALOG'));

// assets
\Bitrix\Main\UI\Extension::load('ui.buttons');
Asset::getInstance()->addCSS('/bitrix/components/bitrix/landing.site_edit/templates/.default/landing-forms.css');
Asset::getInstance()->addJS('/bitrix/components/bitrix/landing.site_edit/templates/.default/landing-forms.js');

// view-functions
include 'template_class.php';
$template = new Template($arResult);

// some url
$uriSave = new \Bitrix\Main\Web\Uri(htmlspecialcharsback(POST_FORM_ACTION_URI));
$uriSave->addParams(array(
	'action' => 'save'
));

// domain
if (\Bitrix\Main\Loader::includeModule('bitrix24'))
{
	$domainName = isset($domains[$row['DOMAIN_ID']['CURRENT']]['DOMAIN'])
				? $domains[$row['DOMAIN_ID']['CURRENT']]['DOMAIN']
				: $row['DOMAIN_ID']['CURRENT'];
}
else
{
	$domainName = $row['DOMAIN_ID']['CURRENT'];
}
?>

<form action="<?= \htmlspecialcharsbx($uriSave->getUri());?>" method="post" class="ui-form ui-form-gray-padding landing-form-collapsed landing-form-settings" id="landing-site-set-form">
	<input type="hidden" name="fields[SAVE_FORM]" value="Y" />
	<input type="hidden" name="fields[TYPE]" value="<?= $arParams['TYPE'];?>" />
	<input type="hidden" name="fields[CODE]" value="<?= $row['CODE']['CURRENT'];?>" />
	<input type="hidden" name="fields[TPL_ID]" value="<?= $row['TPL_ID']['CURRENT'];?>" />
	<input type="hidden" name="fields[LANDING_ID_404]" value="<?= $row['LANDING_ID_404']['CURRENT'];?>" />
	<input type="hidden" name="fields[LANDING_ID_INDEX]" value="<?= $row['LANDING_ID_INDEX']['CURRENT'];?>" />
	<input type="hidden" name="fields[DOMAIN_ID]" value="<?= $domainName;?>" />
	<?if (count($arResult['LANDINGS']) == 1):?>
		<input name="fields[LANDING_ID_INDEX]" type="hidden" value="<?= array_pop(array_keys($arResult['LANDINGS']))?>" />
	<?endif;?>
	<?= bitrix_sessid_post();?>
	<input type="hidden" name="fields[TITLE]" value="<?= $row['TITLE']['CURRENT'];?>" />

	<div class="landing-form-inner-js landing-form-inner landing-form-inner-catalog">
		<div class="landing-form-table-wrap landing-form-table-wrap-js ui-form-inner">
			<div class="landing-form-table-inner landing-ui-panel-content-body-content">
				<table class="ui-form-table landing-form-table">
				<?if (isset($hooks['SETTINGS'])):
					$pageFields = $hooks['SETTINGS']->getPageFields();
					foreach (\Bitrix\Landing\Hook\Page\Settings::getCodes() as $header => $codes)
					{
						if ($header)
						{
							?>
							<tr class="landing-form-title-catalog">
								<td colspan="2">
									<?=Loc::getMessage('LANDING_TPL_HOOK_SETT_HEADER_'.strtoupper($header));?></td>
							</tr>
							<?
						}
						foreach ($codes as $code)
						{
							if (isset($pageFields['SETTINGS_' . $code]))
							{
								$field = $pageFields['SETTINGS_' . $code];
								$label = Loc::getMessage('LANDING_TPL_HOOK_SETT_' . $code);
								$additionalCss = '';
								if (
									$field->getType() == 'select' &&
									$field->isMulti()
								)
								{
									$additionalCss = ' landing-form-select-multi';
								}
								?>
								<tr id="row_<?= strtolower($code);?>">
									<td class="ui-form-label">
										<div class="landing-form-label-inner">
											<?= $label ? $label :$field->getLabel();?>
										</div>
									</td>
									<td class="ui-form-right-cell">
										<div class="landing-form-flex-box landing-form-select-wide">
											<?if ($field->getCode() == 'SETTINGS_SECTION_ID'):?>
												<div id="fieldSectionId" style="width: 100%;"></div>
												<input type="hidden" id="fieldSectionIdReal" <?
													?>name="fields[ADDITIONAL_FIELDS][SETTINGS_SECTION_ID]" <?
													?>value="<?= intval($field->getValue());?>">
												<script type="text/javascript">
													var fieldSection = new BX.Landing.UI.Field.LinkURL({
														title: "",
														textOnly: true,
														disableCustomURL: true,
														disallowType: true,
														allowedTypes: [
															BX.Landing.UI.Field.LinkURL.TYPE_CATALOG
														],
														allowedCatalogEntityTypes: [
															BX.Landing.UI.Panel.Catalog.TYPE_CATALOG_SECTION
														],
														content: "<?= $field->getValue() ? '#catalogSection' . intval($field->getValue()) : '';?>",
														onValueChange: function()
														{
															BX("fieldSectionIdReal").value = fieldSection.getValue().substr(15);
														}
													});
													BX("fieldSectionId").appendChild(fieldSection.layout);
													// if iblock id select exist
													if (BX("settings_iblock_id"))
													{
														BX("row_section_id").classList.add("landing-form-field-section");
														new BX.Landing.IblockSelect();

														BX.bind(
															BX("settings_iblock_id"),
															"change",
															function()
															{
																fieldSection.setIblocks([{
																	name: "iblock",
																	value: BX("settings_iblock_id").value
																}]);

																new BX.Landing.IblockSelect();
															}
														);
													}
												</script>
											<?else:?>
												<?
												$field->viewForm(array(
													'id' => 'settings_' . strtolower($code),
													'class' => $template->getCssByType($field->getType()) . $additionalCss,
													'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
												 ));
												?>
												<?if ($field->getType() == 'checkbox'):?>
												<label for="settings_<?= strtolower($code);?>">
													<?= $field->getLabel();?>
												</label>
												<?endif;?>
											<?endif;?>
										</div>
									</td>
								</tr>
								<?
							}
						}
					}
				endif;?>
				</table>
			</div>
		</div>
	</div>

	<div class="<?if ($request->get('IFRAME') == 'Y'){?>landing-edit-footer-fixed <?}?>pinable-block">
		<div class="landing-form-footer-container">
			<button id="landing-save-btn" type="submit" class="ui-btn ui-btn-success"  name="submit"  value="���������" id="" title="��������� � ������� � ���������" >
				<?= Loc::getMessage('LANDING_TPL_BUTTON_' . ($arParams['SITE_ID'] ? 'SAVE' : 'ADD'));?>
			</button>
			<a class="ui-btn ui-btn-md ui-btn-link"<?if ($request->get('IFRAME') == 'Y'){?> id="action-close"<?}?> href="<?= $arParams['PAGE_URL_SITES']?>" title="�� ��������� � ���������">
				<?= Loc::getMessage('LANDING_TPL_BUTTON_CANCEL')?>
			</a>
		</div>
	</div>

</form>

<script type="text/javascript">
	BX.ready(function(){
		// for save
		new BX.Landing.SaveBtn(BX('landing-save-btn'));
		var editComponent = new BX.Landing.EditComponent();
		top.window['landingSettingsSaved'] = false;
		<?if ($arParams['SUCCESS_SAVE']):?>
		top.window['landingSettingsSaved'] = true;
		top.BX.onCustomEvent('BX.Main.Filter:apply');
		editComponent.actionClose();
		<?endif;?>
	});
</script>