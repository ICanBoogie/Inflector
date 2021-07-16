<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Inflections;

use ICanBoogie\Inflections;
use ICanBoogie\InflectionsConfigurator;

use function explode;

/**
 * Norwegian Bokmal Inflections.
 *
 * @codeCoverageIgnore
 */
final class nb implements InflectionsConfigurator
{
    public static function configure(Inflections $inflections): void
    {
        $inflections
            ->plural('/$/', 'er')
            ->plural('/r$/i', 're')
            ->plural('/e$/i', 'er')
            ->singular('/er$/i', '')
            ->singular('/re$/i', 'r')
            ->irregular('konto', 'konti')
            ->uncountable(explode(' ', 'barn fjell hus'));
    }
}
