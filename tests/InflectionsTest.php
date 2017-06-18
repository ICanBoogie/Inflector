<?php

namespace ICanBoogie;

/**
 * @group integration
 */
class InflectionsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_singular_and_plural
	 *
	 * @param string $locale
	 * @param string $singular
	 * @param string $plural
	 */
	public function test_singular_to_plural($locale, $singular, $plural)
	{
		$this->assertEquals($plural, pluralize($singular, $locale));
	}

	/**
	 * @dataProvider provide_singular_and_plural
	 *
	 * @param string $locale
	 * @param string $singular
	 * @param string $plural
	 */
	public function test_plural_to_singular($locale, $singular, $plural)
	{
		$this->assertEquals($singular, singularize($plural, $locale));
	}

	/**
	 * @return array
	 */
	public function provide_singular_and_plural()
	{
		$locales = explode(' ', 'en es fr nb pt tr');
		$rc = array();

		foreach ($locales as $locale)
		{
			foreach (require __DIR__ . "/Inflections/$locale.php" as $singular => $plural)
			{
				$rc[] = array($locale, $singular, $plural);
			}
		}

		return $rc;
	}
}
