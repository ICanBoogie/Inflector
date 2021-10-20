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

use ICanBoogie\Inflections;
use ICanBoogie\InflectionsNotFound;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\pluralize;
use function ICanBoogie\singularize;

/**
 * @group integration
 */
final class InflectionsTest extends TestCase
{
    public function test_fail_on_undefined_inflections(): void
    {
        $this->expectException(InflectionsNotFound::class);
        $this->expectExceptionMessage("Unable to load inflections for `zz`, tried `ICanBoogie\\Inflections\\zz`.");
        Inflections::get('zz');
    }

    /**
     * @dataProvider provide_singular_and_plural
     */
    public function test_singular_to_plural(string $locale, string $singular, string $plural): void
    {
        $this->assertEquals($plural, pluralize($singular, $locale));
    }

    /**
     * @dataProvider provide_singular_and_plural
     */
    public function test_plural_to_singular(string $locale, string $singular, string $plural): void
    {
        $this->assertEquals($singular, singularize($plural, $locale));
    }

    // @phpstan-ignore-next-line
    public function provide_singular_and_plural(): array
    {
        $locales = explode(' ', 'en es fr nb pt tr');
        $rc = [];

        foreach ($locales as $locale) {
            foreach (require __DIR__ . "/Inflections/$locale.php" as $singular => $plural) {
                $rc[] = [ $locale, $singular, $plural ];
            }
        }

        return $rc;
    }
}
