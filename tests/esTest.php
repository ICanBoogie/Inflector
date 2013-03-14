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

class SpanishInflectionsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Inflector
	 */
	static private $inflector;

	static public function setUpBeforeClass()
	{
		self::$inflector = Inflector::get('es');
	}

	public function test_plurales_regulares()
	{
		$this->assertEquals('libros', self::$inflector->pluralize('libro'));
		$this->assertEquals('libro', self::$inflector->singularize('libros'));

		$this->assertEquals('radios', self::$inflector->pluralize('radio'));
		$this->assertEquals('radio', self::$inflector->singularize('radios'));

		$this->assertEquals('señores', self::$inflector->pluralize('señor'));
		$this->assertEquals('señor', self::$inflector->singularize('señores'));

		$this->assertEquals('leyes', self::$inflector->pluralize('ley'));
		$this->assertEquals('ley', self::$inflector->singularize('leyes'));
	}

	public function test_plurales_que_terminar_en_z()
	{
		$this->assertEquals('meces', self::$inflector->pluralize('mez'));
		$this->assertEquals('luces', self::$inflector->pluralize('luz'));
	}

	public function test_plurales_que_terminar_en_n_o_s_con_acentos()
	{
		$this->assertEquals('aviones', self::$inflector->pluralize('avión'));
		$this->assertEquals('intereses', self::$inflector->pluralize('interés'));
	}

	public function test_plurales_irregulares()
	{
		$this->assertEquals('los', self::$inflector->pluralize('el'));
		$this->assertEquals('el', self::$inflector->singularize('los'));
	}
}