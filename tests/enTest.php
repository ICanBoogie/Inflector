<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

class EnglishInflectionsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Inflector
	 */
	static private $inflector;

	static public function setUpBeforeClass()
	{
		self::$inflector = Inflector::get('en');
	}

	/**
	 * @dataProvider provide_singular_and_plural
	 *
	 * @param string $singular
	 * @param string $plural
	 */
	public function test_plural_to_plural($singular, $plural)
	{
		$this->assertEquals($plural, self::$inflector->pluralize($plural));
	}

	/**
	 * @dataProvider provide_singular_and_plural
	 *
	 * @param string $singular
	 * @param string $plural
	 */
	public function test_singular_to_singular($singular, $plural)
	{
		$this->assertEquals($singular, self::$inflector->singularize($singular));
	}

	public function provide_singular_and_plural()
	{
		$singular_to_plural = require __DIR__ . '/cases/en/singular_to_plural.php';
		$dataset = array();

		foreach ($singular_to_plural as $singular => $plural)
		{
			$dataset[] = array($singular, $plural);
		}

		return $dataset;
	}
}
