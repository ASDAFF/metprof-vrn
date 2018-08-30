<?
if(IsModuleInstalled('landing'))
{
	$updater->CopyFiles("install/components", "components");
	$updater->CopyFiles("install/js", "js");
	$updater->CopyFiles("install/templates", "templates");
	$updater->CopyFiles("install/images", "images");
}

if (defined('BX_COMP_MANAGED_CACHE')) {
	$GLOBALS['CACHE_MANAGER']->clearByTag('landing_blocks');
	$GLOBALS['CACHE_MANAGER']->clearByTag('landing_demo');
}

// work with cloud repo always
if (IsModuleInstalled('landing') && !defined('LANDING_IS_REPO'))
{
	$repoAddr = 'https://repo.bitrix24.site/rest/1/w1uqy3swvyp50bso/';
	\Bitrix\Main\Config\Option::set('landing', 'block_vendor_bitrix', $repoAddr);
	\Bitrix\Main\Config\Option::set('landing', 'disabled_namespaces', 'bitrix');
}

if (!isModuleInstalled("landing"))
{
	$moduleClass = new CModule();
	$module = $moduleClass->CreateModuleObject("landing");
	if ($module)
	{
		$module->installFiles();
		if($updater->CanUpdateDatabase())
		{
			$module->InstallDB();
		}
	}
}

// add / update system tpl
if (
	$updater->CanUpdateDatabase() &&
	\Bitrix\Main\Loader::includeModule('landing')
)
{
	$installTtpl = array(
		'sidebar_right' => array(
			'content' => '<div class="landing-layout-flex sidebar-right">
								<div class="g-width-25x--lg g-max-width-100x landing-sidebar">#AREA_1#</div> 
								<div class="g-width-75x--lg  g-max-width-100x landing-main">#CONTENT#</div> 
							</div>',
			'area_count' => 1
		),
		'without_left' => array(
			'content' => '<div class="landing-header">#AREA_1#</div> 
								<div class="landing-layout-flex without-left">
									<div class="g-width-25x--lg g-max-width-100x landing-sidebar">#AREA_2#</div>
									<div class="g-width-75x--lg g-max-width-100x landing-main">#CONTENT#</div> 
								</div> 
							<div class="landing-footer">#AREA_3#</div>',
			'area_count' => 3
		)
	);
	// first check exist
	$res = \Bitrix\Landing\Template::getList(array(
		 'filter' => array(
			 '=XML_ID' => array_keys($installTtpl)
		 )
	));
	while ($row = $res->fetch())
	{
		$installTtpl[$row['XML_ID']]['id'] = $row['ID'];
	}
	// then add / update
	$i = 0;
	foreach ($installTtpl as $code => $tpl)
	{
		$i += 100;
		$fields = array(
			'XML_ID' => $code,
			'ACTIVE' => 'Y',
			'TITLE' => '#' . strtoupper($code) . '#',
			'CONTENT' => $tpl['content'],
			'AREA_COUNT' => $tpl['area_count'],
			'SORT' => $i
		);
		if (isset($tpl['id']))
		{
			\Bitrix\Landing\Template::update($tpl['id'], $fields);
		}
	}
}

//	update domain in form block just for CP
if (
	!isModuleInstalled("intranet") &&
	\Bitrix\Main\Loader::includeModule('landing')
)
{
	$newDomain = (\CMain::IsHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
	//\Bitrix\Landing\Update\Block\NodeAttributes::updateFormDomain(array('new_domain' => $newDomain));
}


// update MENU blocks
$bugsUpdates = array(
	'PARAMS' => array(
		'UPDATE_PUBLISHED_SITES' => 'Y',
	),
	'BLOCKS' => array(
		'0.menu_01' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_02' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_03' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--fixed',
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_04' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_05' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_06_charity' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_07_construction' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_08_consulting' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
				'.landing-block-node-menu-logo' => array(
					'CLASSES_REMOVE' => array('u-header__logo-img', 'u-header__logo-img--main'),
					'ATTRS_ADD' => array(
						'data-header-fix-moment-exclude' => 'd-block',
						'data-header-fix-moment-classes' => 'd-none',
					),
				),
				'.landing-block-node-menu-logo2' => array(
					'CLASSES_REMOVE' => array('u-header__logo-img', 'u-header__logo-img--main'),
					'CLASSES_ADD' => array('d-none'),
					'ATTRS_ADD' => array(
						'data-header-fix-moment-exclude' => 'd-none',
						'data-header-fix-moment-classes' => 'd-block',
					),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_09_corporate' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_10_courses' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_11_event' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_12_gym' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_13_lawyer' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_14_music' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_15_photography' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_16' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_17_restaurant' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
		'0.menu_18_spa' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_19_travel' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
		),
		'0.menu_20_wedding' => array(
			'NODES' => array(
				'.u-header' => array(
					'CLASSES_ADD' => array('u-header--floating', 'u-header--floating-realtive'),
					'CLASSES_REMOVE' => array(
						'u-header--sticky-top',
						'u-header--change-appearance',
						'u-header--show-hide',
						'u-header--toggle-section',
						'u-header--change-logo',
					),
					'ATTRS_REMOVE' => array('data-header-fix-moment', 'data-header-fix-effect'),
				),
			),
			'SET_SORT' => -100,
			'CLEAR_PHP' => 'Y',
		),
	),
);

//	find unique updaterId by current time
$updaterUniqueId = time();
while (true)
{
	if (\Bitrix\Main\Config\Option::get('landing', 'blocks_attrs_update' . $updaterUniqueId) == '')
	{
		break;
	}
	$updaterUniqueId++;
}

if(IsModuleInstalled('landing'))
{
	\Bitrix\Main\Config\Option::set('landing', 'blocks_attrs_update' . $updaterUniqueId, serialize($bugsUpdates));
	\Bitrix\Main\Update\Stepper::bindClass('\Bitrix\Landing\Update\Block\NodeAttributes', 'landing', 60);
}

?>
