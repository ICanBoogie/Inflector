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
use ICanBoogie\Inflector;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\camelize;

final class InflectorTest extends TestCase
{
    /**
     * @var Inflector
     */
    private static $inflector;

    public static function setUpBeforeClass(): void
    {
        self::$inflector = Inflector::get();
    }

    public function test_pluralize_plurals(): void
    {
        $this->assertEquals("plurals", self::$inflector->pluralize("plurals"));
        $this->assertEquals("Plurals", self::$inflector->pluralize("Plurals"));
    }

    public function test_pluralize_empty_string(): void
    {
        $this->assertEquals("", self::$inflector->pluralize(""));
    }

    public function test_uncountability(): void
    {
        foreach (self::$inflector->inflections->uncountables as $word) {
            $this->assertEquals($word, self::$inflector->singularize($word));
            $this->assertEquals($word, self::$inflector->pluralize($word));
            $this->assertEquals(self::$inflector->pluralize($word), self::$inflector->singularize($word));
        }
    }

    public function test_uncountable_word_is_not_greedy(): void
    {
        $inflector = clone self::$inflector;

        $uncountable_word = "ors";
        $countable_word = "sponsor";

        $inflector->inflections->uncountable($uncountable_word);

        $this->assertEquals($uncountable_word, $inflector->singularize($uncountable_word));
        $this->assertEquals($uncountable_word, $inflector->pluralize($uncountable_word));
        $this->assertEquals($inflector->pluralize($uncountable_word), $inflector->singularize($uncountable_word));

        $this->assertEquals("sponsor", $inflector->singularize($countable_word));
        $this->assertEquals("sponsors", $inflector->pluralize($countable_word));
        $this->assertEquals("sponsor", $inflector->singularize($inflector->pluralize($countable_word)));
    }

    public function test_camelize(): void
    {
        $ar = require __DIR__ . '/cases/camel_to_underscore.php';

        foreach ($ar as $camel => $underscore) {
            $this->assertEquals($camel, self::$inflector->camelize($underscore));
            $this->assertEquals($camel, camelize($underscore));
        }

        $ar = require __DIR__ . '/cases/camel_to_dash.php';

        foreach ($ar as $camel => $dash) {
            $this->assertEquals($camel, self::$inflector->camelize($dash));
            $this->assertEquals($camel, camelize($dash));
        }
    }

    public function test_camelize_with_lower_upcases_the_first_letter(): void
    {
        $this->assertEquals('Capital', self::$inflector->camelize('capital'));
        $this->assertEquals('Capital', camelize('capital'));
    }

    public function test_camelize_preserve_words_ends(): void
    {
        $this->assertEquals('WordOne\\WordTwo', self::$inflector->camelize('wordOne/wordTwo'));
        $this->assertEquals('WordOne\\WordTwo', camelize('wordOne/wordTwo'));
    }

    public function test_camelize_with_lower_downcases_the_first_letter(): void
    {
        $this->assertEquals('capital', self::$inflector->camelize('Capital', true));
        $this->assertEquals('capital', camelize('Capital', true));
    }

    public function test_camelize_with_underscores(): void
    {
        $this->assertEquals("CamelCase", self::$inflector->camelize('Camel_Case'));
        $this->assertEquals("CamelCase", camelize('Camel_Case'));
    }

    public function test_acronyms(): void
    {
        $inflect = clone self::$inflector;
        $inflections = $inflect->inflections;
        $inflections->acronym("API");
        $inflections->acronym("HTML");
        $inflections->acronym("HTTP");
        $inflections->acronym("RESTful");
        $inflections->acronym("W3C");
        $inflections->acronym("PhD");
        $inflections->acronym("RoR");
        $inflections->acronym("SSL");

        # camelize underscore humanize titleize
        $ar = [
            [ "API", "api", "API", "API" ],
            [ "APIController", "api_controller", "API controller", "API Controller" ],
            [ "Nokogiri\HTML", "nokogiri/html", "Nokogiri/HTML", "Nokogiri/HTML" ],
            [ "HTTPAPI", "http_api", "HTTP API", "HTTP API" ],
            [ "HTTP\Get", "http/get", "HTTP/get", "HTTP/Get" ],
            [ "SSLError", "ssl_error", "SSL error", "SSL Error" ],
            [ "RESTful", "restful", "RESTful", "RESTful" ],
            [ "RESTfulController", "restful_controller", "RESTful controller", "RESTful Controller" ],
            [ "IHeartW3C", "i_heart_w3c", "I heart W3C", "I Heart W3C" ],
            [ "PhDRequired", "phd_required", "PhD required", "PhD Required" ],
            [ "IRoRU", "i_ror_u", "I RoR u", "I RoR U" ],
            [ "RESTfulHTTPAPI", "restful_http_api", "RESTful HTTP API", "RESTful HTTP API" ],

            # misdirection
            [ "Capistrano", "capistrano", "Capistrano", "Capistrano" ],
            [ "CapiController", "capi_controller", "Capi controller", "Capi Controller" ],
            [ "HttpsApis", "https_apis", "Https apis", "Https Apis" ],
            [ "Html5", "html5", "Html5", "Html5" ],
            [ "Restfully", "restfully", "Restfully", "Restfully" ],
            [ "RoRails", "ro_rails", "Ro rails", "Ro Rails" ]
        ];

        foreach ($ar as $a) {
            [ $camel, $under, $human, $title ] = $a;

            $this->assertEquals($camel, $inflect->camelize($under));
            $this->assertEquals($camel, $inflect->camelize($camel));
            $this->assertEquals($under, $inflect->underscore($under));
            $this->assertEquals($under, $inflect->underscore($camel));
            $this->assertEquals($title, $inflect->titleize($under));
            $this->assertEquals($title, $inflect->titleize($camel));
            $this->assertEquals($human, $inflect->humanize($under));
        }
    }

    public function test_acronym_override(): void
    {
        $inflect = clone self::$inflector;
        $inflections = $inflect->inflections;
        $inflections->acronym("API");
        $inflections->acronym("LegacyApi");

        $this->assertEquals("LegacyApi", $inflect->camelize("legacyapi"));
        $this->assertEquals("LegacyAPI", $inflect->camelize("legacy_api"));
        $this->assertEquals("SomeLegacyApi", $inflect->camelize("some_legacyapi"));
        $this->assertEquals("Nonlegacyapi", $inflect->camelize("nonlegacyapi"));
    }

    public function test_acronyms_camelize_lower(): void
    {
        $inflect = clone self::$inflector;
        $inflections = $inflect->inflections;
        $inflections->acronym("API");
        $inflections->acronym("HTML");

        $this->assertEquals("htmlAPI", $inflect->camelize("html_api", true));
        $this->assertEquals("htmlAPI", $inflect->camelize("htmlAPI", true));
        $this->assertEquals("htmlAPI", $inflect->camelize("HTMLAPI", true));
    }

    public function test_underscore_to_lower_camel(): void
    {
        foreach (require __DIR__ . '/cases/underscore_to_lower_camel.php' as $underscored => $lower_camel) {
            $this->assertEquals($lower_camel, self::$inflector->camelize($underscored, true));
        }
    }

    public function test_camelize_with_namespace(): void
    {
        $cases = '/cases/camel_with_namespace_to_underscore_with_slash.php';

        foreach (require __DIR__ . $cases as $camel => $underscore) {
            $this->assertEquals($camel, self::$inflector->camelize($underscore));
        }
    }

    public function test_underscore_acronym_sequence(): void
    {
        $inflect = clone self::$inflector;
        $inflections = $inflect->inflections;
        $inflections->acronym("API");
        $inflections->acronym("JSON");
        $inflections->acronym("HTML");

        $this->assertEquals("json_html_api", $inflect->underscore("JSONHTMLAPI"));
    }

    public function test_underscore(): void
    {
        foreach (require __DIR__ . '/cases/camel_to_underscore.php' as $camel => $underscore) {
            $this->assertEquals($underscore, self::$inflector->underscore($camel));
        }

        foreach (require __DIR__ . '/cases/camel_to_underscore_without_reverse.php' as $camel => $underscore) {
            $this->assertEquals($underscore, self::$inflector->underscore($camel));
        }

        foreach (require __DIR__ . '/cases/misc_to_underscore.php' as $misc => $underscore) {
            $this->assertEquals($underscore, self::$inflector->underscore($misc));
        }
    }

    public function test_underscore_with_slashes(): void
    {
        $cases = '/cases/camel_with_namespace_to_underscore_with_slash.php';

        foreach (require __DIR__ . $cases as $camel => $underscore) {
            $this->assertEquals($underscore, self::$inflector->underscore($camel));
        }
    }

    public function test_hyphenate(): void
    {
        $ar = [
            'AlterCSSClassNames' => 'alter-css-class-names'
        ];

        $inflector = self::$inflector;

        foreach ($ar as $str => $hyphenated) {
            $this->assertEquals($hyphenated, $inflector->hyphenate($str));
        }

        foreach (require __DIR__ . '/cases/underscores_to_dashes.php' as $underscore => $dash) {
            $this->assertEquals($dash, self::$inflector->hyphenate($underscore));
        }

        foreach (require __DIR__ . '/cases/misc_to_hyphens.php' as $misc => $dash) {
            $this->assertEquals($dash, self::$inflector->hyphenate($misc));
        }
    }

    public function test_humanize(): void
    {
        foreach (require __DIR__ . '/cases/underscore_to_human.php' as $underscore => $human) {
            $this->assertEquals($human, self::$inflector->humanize($underscore));
        }
    }

    public function test_humanize_by_rule(): void
    {
        $inflector = clone self::$inflector;
        $inflections = $inflector->inflections;
        $inflections->human('/_cnt$/i', '\1_count');
        $inflections->human('/^prefx_/i', '\1');

        $this->assertEquals("Jargon count", $inflector->humanize("jargon_cnt"));
        $this->assertEquals("Request", $inflector->humanize("prefx_request"));
    }

    public function test_humanize_by_string(): void
    {
        $inflector = clone self::$inflector;
        $inflections = $inflector->inflections;
        $inflections->human("col_rpted_bugs", "Reported bugs");

        $this->assertEquals("Reported bugs", $inflector->humanize("col_rpted_bugs"));
        $this->assertEquals("Col rpted bugs", $inflector->humanize("COL_rpted_bugs"));
    }

    public function test_ordinal(): void
    {
        foreach (require __DIR__ . '/cases/ordinal_numbers.php' as $number => $ordinalized) {
            $this->assertEquals($ordinalized, $number . self::$inflector->ordinal($number));
        }
    }

    public function test_ordinalize(): void
    {
        foreach (require __DIR__ . '/cases/ordinal_numbers.php' as $number => $ordinalized) {
            $this->assertEquals($ordinalized, self::$inflector->ordinalize($number));
        }
    }

    public function test_dasherize(): void
    {
        foreach (require __DIR__ . '/cases/underscores_to_dashes.php' as $underscored => $dasherized) {
            $this->assertEquals($dasherized, self::$inflector->dasherize($underscored));
        }
    }

    public function test_underscore_as_reverse_of_dasherize(): void
    {
        foreach (require __DIR__ . '/cases/underscores_to_dashes.php' as $underscored => $dasherized) {
            $this->assertEquals($underscored, self::$inflector->underscore(self::$inflector->dasherize($underscored)));
        }
    }

    public function test_humanize_accentuated_characters(): void
    {
        $this->assertEquals("Été aux âmes inouïes", self::$inflector->humanize("été_aux_âmes_inouïes"));
    }

    public function test_titleize_accentuated_characters(): void
    {
        $this->assertEquals("L'été Aux Âmes Inouïes", self::$inflector->titleize("l'été_aux_âmes_inouïes"));
    }

    public function test_is_uncountable(): void
    {
        $inflections = new Inflections();
        $inflections->uncountable($uncountable = uniqid());
        $inflector = new Inflector($inflections);

        $this->assertTrue($inflector->is_uncountable($uncountable));
        $this->assertFalse($inflector->is_uncountable(uniqid()));
    }
}
