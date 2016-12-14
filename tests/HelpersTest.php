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

/**
 * @group helpers
 */
class HelpersTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_capitalize
	 *
	 * @param string $str
	 * @param bool $preserve_str_end
	 * @param string $expected
	 */
	public function test_capitalize($str, $preserve_str_end, $expected)
	{
		$this->assertSame($expected, capitalize($str, $preserve_str_end));
	}

	/**
	 * @return array
	 */
	public function provide_test_capitalize()
	{
		return array(

			array("été Ensoleillé", false, "Été ensoleillé"),
			array("été Ensoleillé", true, "Été Ensoleillé"),

		);
	}
}
