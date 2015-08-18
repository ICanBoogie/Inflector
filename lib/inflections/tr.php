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
 * Turkish inflections.
 *
 * @param Inflections $inflect
 */
//@codeCoverageIgnoreStart
return function(Inflections $inflect) {

	$inflect
	->plural('/([aoıu][^aoıueöiü]{0,6})$/u', '\1lar')
	->plural('/([eöiü][^aoıueöiü]{0,6})$/u', '\1ler')

	->singular('/l[ae]r$/i', '')

	->irregular('ben', 'biz')
	->irregular('sen', 'siz')
	->irregular('o', 'onlar');

};
//@codeCoverageIgnoreEnd
