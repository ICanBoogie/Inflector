<?php

namespace Tests\ICanBoogie;

use ICanBoogie\StaticInflector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class StaticInflectorTest extends TestCase
{
    public function test_downcase(): void
    {
        $this->assertEquals(
            "îñfléçtör",
            StaticInflector::downcase("ÎñflÉÇtÖr")
        );
    }

    public function test_upcase(): void
    {
        $this->assertEquals(
            "ÎÑFLÉÇTÖR",
            StaticInflector::upcase("ÎñflÉÇtÖr")
        );
    }

    public function test_capitalize(): void
    {
        $this->assertEquals(
            "Été ensoleillé",
            StaticInflector::capitalize("été Ensoleillé")
        );

        $this->assertEquals(
            "Été Ensoleillé",
            StaticInflector::capitalize("été Ensoleillé", true)
        );
    }

    /**
     * @dataProvider provide_pluralize
     */
    #[DataProvider('provide_pluralize')]
    public function test_pluralize(string $locale, string $word, string $expected): void
    {
        $actual = StaticInflector::pluralize($word, $locale);

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
        $actual = StaticInflector::singularize($word, $locale);

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
            StaticInflector::camelize("area51_controller")
        );
    }

    public function test_underscore(): void
    {
        $this->assertEquals(
            "area51_controller",
            StaticInflector::underscore("Area51Controller")
        );
    }

    public function test_hyphenate(): void
    {
        $this->assertEquals(
            "johnny5-still-alive",
            StaticInflector::hyphenate("Johnny5 Still alive")
        );
    }

    public function test_humanize(): void
    {
        $this->assertEquals(
            "Employee salary",
            StaticInflector::humanize("employee_salary")
        );
    }

    public function test_titleize(): void
    {
        $this->assertEquals(
            "Restful Http Api",
            StaticInflector::titleize("restful_http_api")
        );
    }
}
