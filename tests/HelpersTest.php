<?php

namespace Tests\ICanBoogie;

require_once __DIR__ . '/../lib/helpers.php';

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\camelize;
use function ICanBoogie\capitalize;
use function ICanBoogie\downcase;
use function ICanBoogie\humanize;
use function ICanBoogie\hyphenate;
use function ICanBoogie\pluralize;
use function ICanBoogie\singularize;
use function ICanBoogie\titleize;
use function ICanBoogie\underscore;
use function ICanBoogie\upcase;

final class HelpersTest extends TestCase
{
    public function test_downcase(): void
    {
        $this->assertEquals(
            "îñfléçtör",
            downcase("ÎñflÉÇtÖr")
        );
    }

    public function test_upcase(): void
    {
        $this->assertEquals(
            "ÎÑFLÉÇTÖR",
            upcase("ÎñflÉÇtÖr")
        );
    }

    public function test_capitalize(): void
    {
        $this->assertEquals(
            "Été ensoleillé",
            capitalize("été Ensoleillé")
        );

        $this->assertEquals(
            "Été Ensoleillé",
            capitalize("été Ensoleillé", true)
        );
    }

    /**
     * @dataProvider provide_pluralize
     */
    #[DataProvider('provide_pluralize')]
    public function test_pluralize(string $locale, string $word, string $expected): void
    {
        $actual = pluralize($word, $locale);

        $this->assertEquals($expected, $actual);
    }

    public static function provide_pluralize(): array
    {
        return [
            [ "en", "search", "searches" ],
            [ "fr", 'fidèle', "fidèles"]
        ];
    }

    /**
     * @dataProvider provide_singularize
     */
    #[DataProvider('provide_singularize')]
    public function test_singularize(string $locale, string $word, string $expected): void
    {
        $actual = singularize($word, $locale);

        $this->assertEquals($expected, $actual);
    }

    public static function provide_singularize(): array
    {
        return [
            [ "es", "libros", "libro" ],
            [ "nb", "fjorder", 'fjord']
        ];
    }

    public function test_camelize(): void
    {
        $this->assertEquals(
            "Area51Controller",
            camelize("area51_controller")
        );
    }

    public function test_underscore(): void
    {
        $this->assertEquals(
            "area51_controller",
            underscore("Area51Controller")
        );
    }

    public function test_hyphenate(): void
    {
        $this->assertEquals(
            "johnny5-still-alive",
            hyphenate("Johnny5 Still alive")
        );
    }

    public function test_humanize(): void
    {
        $this->assertEquals(
            "Employee salary",
            humanize("employee_salary")
        );
    }

    public function test_titleize(): void
    {
        $this->assertEquals(
            "Restful Http Api",
            titleize("restful_http_api")
        );
    }
}
