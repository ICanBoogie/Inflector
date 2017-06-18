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

class TurkishInflectionsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_irregular
	 */
	public function test_irregular($singular, $plural)
	{
		$this->assertEquals($singular, singularize($plural, 'tr'));
		$this->assertEquals($plural, pluralize($singular, 'tr'));
	}

	public function provide_irregular()
	{
		$rc = array();

		foreach (require __DIR__ . '/cases/tr/irregular.php' as $singular => $plural)
		{
			$rc[] = array($singular, $plural);
		}

		return $rc;
	}
}
