<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\ICanBoogie;

use PHPUnit\Framework\TestCase;

use function ICanBoogie\capitalize;

/**
 * @group helpers
 */
final class HelpersTest extends TestCase
{
    /**
     * @dataProvider provide_test_capitalize
     */
    public function test_capitalize(string $str, bool $preserve_str_end, string $expected): void
    {
        $this->assertSame($expected, capitalize($str, $preserve_str_end));
    }

    public function provide_test_capitalize(): array
    {
        return [

            [ "été Ensoleillé", false, "Été ensoleillé" ],
            [ "été Ensoleillé", true, "Été Ensoleillé" ],

        ];
    }
}
