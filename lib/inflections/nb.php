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
 * Norwegian Bokmal inflections.
 *
 * @param Inflections $inflect
 */
//@codeCoverageIgnoreStart
return function(Inflections $inflect) {

	$inflect
    ->plural('/$/', 'er')
    ->plural('/r$/i', 're')
    ->plural('/e$/i', 'er')

    ->singular('/er$/i', '')
    ->singular('/re$/i', 'r')

    ->irregular('konto', 'konti');

};
//@codeCoverageIgnoreEnd
