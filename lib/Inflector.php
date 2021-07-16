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

use InvalidArgumentException;

use function assert;
use function is_string;

/**
 * The Inflector transforms words from singular to plural, class names to table names, modularized
 * class names to ones without, and class names to foreign keys. Inflections can be localized, the
 * default english inflections for pluralization, singularization, and uncountable words are
 * kept in `lib/Inflections/en.php`.
 *
 * @property-read Inflections $inflections Inflections used by the inflector.
 */
class Inflector
{
    /**
     * Default inflector locale.
     *
     * Alias to {@link INFLECTOR_DEFAULT_LOCALE}.
     */
    public const DEFAULT_LOCALE = INFLECTOR_DEFAULT_LOCALE;

    /**
     * {@link camelize()} option to downcase the first letter.
     */
    public const DOWNCASE_FIRST_LETTER = true;

    /**
     * {@link camelize()} option to keep the first letter as is.
     */
    public const UPCASE_FIRST_LETTER = false;

    /**
     * @var array<string, Inflector>
     */
    private static $inflectors = [];

    /**
     * Returns an inflector for the specified locale.
     *
     * Note: Inflectors are shared for the same locale. If you need to alter an inflector you
     * MUST clone it first.
     */
    public static function get(string $locale = self::DEFAULT_LOCALE): self
    {
        return self::$inflectors[$locale]
            ?? self::$inflectors[$locale] = new self(Inflections::get($locale));
    }

    /**
     * Inflections used by the inflector.
     *
     * @var Inflections
     */
    private $inflections;

    public function __construct(Inflections $inflections = null)
    {
        $this->inflections = $inflections ?? new Inflections();
    }

    /**
     * Returns the {@link $inflections} property.
     *
     * @return mixed
     * @throws PropertyNotDefined in attempt to read an inaccessible property. If the {@link PropertyNotDefined}
     * class is not available a {@link InvalidArgumentException} is thrown instead.
     */
    public function __get(string $property)
    {
        if ($property === 'inflections') {
            return $this->$property;
        }

        if (class_exists(PropertyNotDefined::class)) {
            throw new PropertyNotDefined([ $property, $this ]);
        } else {
            throw new InvalidArgumentException("Property not defined: $property");
        }
    }

    /**
     * Clone inflections.
     */
    public function __clone()
    {
        $this->inflections = clone $this->inflections;
    }

    /**
     * Applies inflection rules for {@link singularize} and {@link pluralize}.
     *
     * <pre>
     * $this->apply_inflections('post', $this->plurals);    // "posts"
     * $this->apply_inflections('posts', $this->singulars); // "post"
     * </pre>
     *
     * @param array<string, string> $rules
     */
    private function apply_inflections(string $word, array $rules): string
    {
        $rc = $word;

        if (!$rc) {
            return $rc;
        }

        if (preg_match('/\b[[:word:]]+\Z/u', downcase($rc), $matches)) {
            if (isset($this->inflections->uncountables[$matches[0]])) {
                return $rc;
            }
        }

        foreach ($rules as $rule => $replacement) {
            assert(is_string($rc));

            $rc = preg_replace($rule, $replacement, $rc, -1, $count);

            if ($count) {
                break;
            }
        }

        assert(is_string($rc));

        return $rc;
    }

    /**
     * Returns the plural form of the word in the string.
     *
     * <pre>
     * $this->pluralize('post');       // "posts"
     * $this->pluralize('children');   // "child"
     * $this->pluralize('sheep');      // "sheep"
     * $this->pluralize('words');      // "words"
     * $this->pluralize('CamelChild'); // "CamelChildren"
     * </pre>
     */
    public function pluralize(string $word): string
    {
        return $this->apply_inflections($word, $this->inflections->plurals);
    }

    /**
     * The reverse of {@link pluralize}, returns the singular form of a word in a string.
     *
     * <pre>
     * $this->singularize('posts');         // "post"
     * $this->singularize('children');      // "child"
     * $this->singularize('sheep');         // "sheep"
     * $this->singularize('word');          // "word"
     * $this->singularize('CamelChildren'); // "CamelChild"
     * </pre>
     */
    public function singularize(string $word): string
    {
        return $this->apply_inflections($word, $this->inflections->singulars);
    }

    /**
     * By default, {@link camelize} converts strings to UpperCamelCase.
     *
     * {@link camelize} will also convert "/" to "\" which is useful for converting paths to
     * namespaces.
     *
     * <pre>
     * $this->camelize('active_model');                // 'ActiveModel'
     * $this->camelize('active_model', true);          // 'activeModel'
     * $this->camelize('active_model/errors');         // 'ActiveModel\Errors'
     * $this->camelize('active_model/errors', true);   // 'activeModel\Errors'
     * </pre>
     *
     * As a rule of thumb you can think of {@link camelize} as the inverse of {@link underscore},
     * though there are cases where that does not hold:
     *
     * <pre>
     * $this->camelize($this->underscore('SSLError')); // "SslError"
     * </pre>
     *
     * @param bool $downcase_first_letter One of {@link UPCASE_FIRST_LETTER},
     * {@link DOWNCASE_FIRST_LETTER}.
     */
    public function camelize(string $term, bool $downcase_first_letter = self::UPCASE_FIRST_LETTER): string
    {
        $string = $term;
        $acronyms = $this->inflections->acronyms;

        if ($downcase_first_letter) {
            $string = preg_replace_callback(
                '/^(?:'
                . trim($this->inflections->acronym_regex, '/')
                . '(?=\b|[[:upper:]_])|\w)/u',
                function (array $matches): string {
                    return downcase($matches[0]);
                },
                $string,
                1
            );
        } else {
            $string = preg_replace_callback(
                '/^[[:lower:]\d]*/u',
                function (array $matches) use ($acronyms): string {
                    $m = $matches[0];

                    return !empty($acronyms[$m]) ? $acronyms[$m] : capitalize($m, true);
                },
                $string,
                1
            );
        }

        assert(is_string($string));

        $string = preg_replace_callback(
            '/(?:_|-|(\/))([[:alnum:]]*)/u',
            function (array $matches) use ($acronyms): string {
                [ , $m1, $m2 ] = $matches;

                return $m1 . ($acronyms[$m2] ?? capitalize($m2, true));
            },
            $string
        );

        assert(is_string($string));

        return str_replace('/', '\\', $string);
    }

    /**
     * Makes an underscored, lowercase form from the expression in the string.
     *
     * Changes "\" to "/" to convert namespaces to paths.
     *
     * <pre>
     * $this->underscore('ActiveModel');        // 'active_model'
     * $this->underscore('ActiveModel\Errors'); // 'active_model/errors'
     * </pre>
     *
     * As a rule of thumb you can think of {@link underscore} as the inverse of {@link camelize()},
     * though there are cases where that does not hold:
     *
     * <pre>
     * $this->camelize($this->underscore('SSLError')); // "SslError"
     * </pre>
     */
    public function underscore(string $camel_cased_word): string
    {
        $word = $camel_cased_word;
        $word = str_replace('\\', '/', $word);
        $word = preg_replace_callback(
            '/(?:([[:alpha:]\d])|^)('
            . trim($this->inflections->acronym_regex, '/')
            . ')(?=\b|[^[:lower:]])/u',
            function (array $matches): string {
                [ , $m1, $m2 ] = $matches;

                return $m1 . ($m1 ? '_' : '') . downcase($m2);
            },
            $word
        );

        // @phpstan-ignore-next-line
        $word = preg_replace('/([[:upper:]\d]+)([[:upper:]][[:lower:]])/u', '\1_\2', $word);
        // @phpstan-ignore-next-line
        $word = preg_replace('/([[:lower:]\d])([[:upper:]])/u', '\1_\2', $word);
        // @phpstan-ignore-next-line
        $word = preg_replace('/\-+|\s+/', '_', $word);

        // @phpstan-ignore-next-line
        return downcase($word);
    }

    /**
     * Capitalizes the first word and turns underscores into spaces and strips a trailing "_id",
     * if any. Like {@link titleize()}, this is meant for creating pretty output.
     *
     * <pre>
     * $this->humanize('employee_salary'); // "Employee salary"
     * $this->humanize('author_id');       // "Author"
     * </pre>
     */
    public function humanize(string $lower_case_and_underscored_word): string
    {
        $result = $lower_case_and_underscored_word;

        foreach ($this->inflections->humans as $rule => $replacement) {
            // @phpstan-ignore-next-line
            $result = preg_replace($rule, $replacement, $result, 1, $count);

            if ($count) {
                break;
            }
        }

        $acronyms = $this->inflections->acronyms;

        // @phpstan-ignore-next-line
        $result = preg_replace('/_id$/', "", $result);
        // @phpstan-ignore-next-line
        $result = strtr($result, '_', ' ');
        $result = preg_replace_callback(
            '/([[:alnum:]]+)/u',
            function (array $matches) use ($acronyms): string {
                [ $m ] = $matches;

                return !empty($acronyms[$m]) ? $acronyms[$m] : downcase($m);
            },
            $result
        );

        assert(is_string($result));

        // @phpstan-ignore-next-line
        return preg_replace_callback('/^[[:lower:]]/u', function (array $matches): string {
            return upcase($matches[0]);
        }, $result);
    }

    /**
     * Capitalizes all the words and replaces some characters in the string to create a nicer
     * looking title. {@link titleize()} is meant for creating pretty output. It is not used in
     * the Rails internals.
     *
     * <pre>
     * $this->titleize('man from the boondocks');  // "Man From The Boondocks"
     * $this->titleize('x-men: the last stand');   // "X Men: The Last Stand"
     * $this->titleize('TheManWithoutAPast');      // "The Man Without A Past"
     * $this->titleize('raiders_of_the_lost_ark'); // "Raiders Of The Lost Ark"
     * </pre>
     */
    public function titleize(string $str): string
    {
        $str = $this->underscore($str);
        $str = $this->humanize($str);

        // @phpstan-ignore-next-line
        return preg_replace_callback('/\b(?<![\'’`])[[:lower:]]/u', function (array $matches): string {
            return upcase($matches[0]);
        }, $str);
    }

    /**
     * Replaces underscores with dashes in the string.
     *
     * <pre>
     * $this->dasherize('puni_puni'); // "puni-puni"
     * </pre>
     */
    public function dasherize(string $underscored_word): string
    {
        return strtr($underscored_word, '_', '-');
    }

    /**
     * Makes an hyphenated, lowercase form from the expression in the string.
     *
     * This is a combination of {@link underscore} and {@link dasherize}.
     */
    public function hyphenate(string $str): string
    {
        return $this->dasherize($this->underscore($str));
    }

    /**
     * Returns the suffix that should be added to a number to denote the position in an ordered
     * sequence such as 1st, 2nd, 3rd, 4th.
     *
     * <pre>
     * $this->ordinal(1);     // "st"
     * $this->ordinal(2);     // "nd"
     * $this->ordinal(1002);  // "nd"
     * $this->ordinal(1003);  // "rd"
     * $this->ordinal(-11);   // "th"
     * $this->ordinal(-1021); // "st"
     * </pre>
     */
    public function ordinal(int $number): string
    {
        $abs_number = abs($number);

        if (($abs_number % 100) > 10 && ($abs_number % 100) < 14) {
            return 'th';
        }

        switch ($abs_number % 10) {
            case 1:
                return "st";
            case 2:
                return "nd";
            case 3:
                return "rd";
            default:
                return "th";
        }
    }

    /**
     * Turns a number into an ordinal string used to denote the position in an ordered sequence
     * such as 1st, 2nd, 3rd, 4th.
     *
     * <pre>
     * $this->ordinalize(1);     // "1st"
     * $this->ordinalize(2);     // "2nd"
     * $this->ordinalize(1002);  // "1002nd"
     * $this->ordinalize(1003);  // "1003rd"
     * $this->ordinalize(-11);   // "-11th"
     * $this->ordinalize(-1021); // "-1021st"
     * </pre>
     */
    public function ordinalize(int $number): string
    {
        return $number . $this->ordinal($number);
    }

    /**
     * Returns true if the word is uncountable, false otherwise.
     *
     * <pre>
     * $this->is_uncountable('advice');    // true
     * $this->is_uncountable('weather');   // true
     * $this->is_uncountable('cat');       // false
     * </pre>
     */
    public function is_uncountable(string $word): bool
    {
        $rc = $word;

        return $rc
            && preg_match('/\b[[:word:]]+\Z/u', downcase($rc), $matches)
            && isset($this->inflections->uncountables[$matches[0]]);
    }
}
