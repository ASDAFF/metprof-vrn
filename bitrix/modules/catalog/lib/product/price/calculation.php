<?php
namespace Bitrix\Catalog\Product\Price;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Catalog,
	Bitrix\Currency;

Loc::loadMessages(__FILE__);

/**
 * Class Calculation
 * Provides methods for product price calculation (discounts, round, precision).
 *
 * @package Bitrix\Catalog\Product\Price
 */
class Calculation
{
	protected static $config = array(
		'CURRENCY' => null,
		'PRECISION' => null
	);

	private static $stack = array();

	/**
	 * Set calculation settings.
	 *
	 * @param array $config
	 *  keys are case sensitive:
	 *		<ul>
	 * 		<li>string CURRENCY				Result currency (can be null - use base currency (compatibility only)).
	 *		<li>int PRECISION				Calculation precision (can be null - use default catalog precision - CATALOG_VALUE_PRECISION).
	 *		</ul>
	 * @return void
	 */
	public static function setConfig(array $config)
	{
		$config = static::checkConfig($config);
		if (empty($config))
			return;

		self::$config = array_merge(self::$config, $config);
	}

	/**
	 * Return current calculation settings.
	 *
	 * @return array
	 */
	public static function getConfig()
	{
		return self::$config;
	}

	/**
	 * Save current calculation settings to the stack before the changes.
	 *
	 * @return void
	 */
	public static function pushConfig()
	{
		array_push(self::$stack, static::getConfig());
	}

	/**
	 * Set the calculation settings from the stack, if it is not empty.
	 *
	 * @return void
	 */
	public static function popConfig()
	{
		if (empty(self::$stack))
			return;
		static::setConfig(array_pop(self::$stack));
	}

	/**
	 * Return result calculation currency.
	 *
	 * @return string
	 */
	public static function getCurrency()
	{
		return (self::$config['CURRENCY'] !== null ? self::$config['CURRENCY'] : Currency\CurrencyManager::getBaseCurrency());
	}

	/**
	 * Return calculation precision.
	 *
	 * @return int
	 */
	public static function getPrecision()
	{
		return (self::$config['PRECISION'] !== null ? self::$config['PRECISION'] : CATALOG_VALUE_PRECISION);
	}

	/**
	 * Round price or discount value.
	 *
	 * @param float|int $value		Value for rounding.
	 * @return float
	 */
	public static function roundPrecision($value)
	{
		return roundEx($value, static::getPrecision());
	}

	/**
	 * Validate new settings (allowed keys and values).
	 * @internal
	 *
	 * @param array $config		New config.
	 * @return array
	 */
	protected static function checkConfig(array $config)
	{
		$result = array();

		$config = array_intersect_key($config, self::$config);
		if (!empty($config))
		{
			foreach ($config as $field => $value)
			{
				$checked = true;
				switch ($field)
				{
					case 'CURRENCY':
						if ($value !== null)
						{
							$value = (string)$value;
							$checked = Currency\CurrencyManager::isCurrencyExist($value);
						}
						break;
					case 'PRECISION':
						if ($value !== null)
						{
							$value = (int)$value;
							$checked = ($value > 0);
						}
						break;
					default:
						break;
				}
				if ($checked)
					$result[$field] = $value;
			}
			unset($field);
		}
		unset($fieldList);

		return $result;
	}
}