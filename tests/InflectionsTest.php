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
	 * @dataProvider provide_singular_and_plural
	 *
	 * @param string $locale
	 * @param string $singular
	 * @param string $plural
	 */
	public function test_is_singular($locale, $singular, $plural)
	{
		$matched = preg_match('/\b[[:word:]]+\Z/u', downcase($singular), $matches);
		if ($matched && isset(Inflector::get($locale)->inflections->uncountables[$matches[0]])) {
			$this->assertTrue(Inflector::get($locale)->is_uncountable($singular));
			$this->assertTrue(Inflector::get($locale)->is_uncountable($plural));
		} else {
			$this->assertTrue(Inflector::get($locale)->is_singular($singular));
			$this->assertFalse($singular != $plural && Inflector::get($locale)->is_singular($plural));
		}
	}

	/**
	 * @dataProvider provide_singular_and_plural
	 *
	 * @param string $locale
	 * @param string $singular
	 * @param string $plural
	 */
	public function test_is_plural($locale, $singular, $plural)
	{
		$matched = preg_match('/\b[[:word:]]+\Z/u', downcase($singular), $matches);
		if (!$matched) var_dump($matches);
		if ($matched && isset(Inflector::get($locale)->inflections->uncountables[$matches[0]])) {
			$this->assertTrue(Inflector::get($locale)->is_uncountable($singular));
			$this->assertTrue(Inflector::get($locale)->is_uncountable($plural));
		} else {
			$this->assertTrue(Inflector::get($locale)->is_plural($plural));
			$this->assertFalse($singular != $plural && Inflector::get($locale)->is_plural($singular));
		}
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
