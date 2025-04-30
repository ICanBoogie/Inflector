<?php

namespace ICanBoogie;

/**
 * A static inflector that uses {@see Inflector::get()} to get inflectors for the specified locale.
 */
final class StaticInflector
{
    /**
     * Returns a lowercase string.
     */
    public static function downcase(string $str): string
    {
        return mb_strtolower($str);
    }

    /**
     * Returns an uppercase string.
     */
    public static function upcase(string $str): string
    {
        return mb_strtoupper($str);
    }

    /**
     * Returns a copy of str with the first character converted to uppercase and the
     * remainder to lowercase.
     *
     * @param bool $preserve_str_end Whether the string end should be preserved or downcased.
     */
    public static function capitalize(string $str, bool $preserve_str_end = false): string
    {
        $end = mb_substr($str, 1);

        if (!$preserve_str_end) {
            $end = self::downcase($end);
        }

        return self::upcase(mb_substr($str, 0, 1)) . $end;
    }

    /**
     * @see Inflector::pluralize()
     */
    public static function pluralize(string $word, string $locale = Inflector::DEFAULT_LOCALE): string
    {
        return Inflector::get($locale)->pluralize($word);
    }

    /**
     * @see Inflector::singularize()
     */
    public static function singularize(string $word, string $locale = Inflector::DEFAULT_LOCALE): string
    {
        return Inflector::get($locale)->singularize($word);
    }

    /**
     * @see Inflector::camelize()
     */
    public static function camelize(
        string $str,
        bool $uppercase_first_letter = false,
        string $locale = Inflector::DEFAULT_LOCALE
    ): string {
        return Inflector::get($locale)->camelize($str, $uppercase_first_letter);
    }

    /**
     * @see Inflector::underscore()
     */
    public static function underscore(string $camel_cased_word, string $locale = Inflector::DEFAULT_LOCALE): string
    {
        return Inflector::get($locale)->underscore($camel_cased_word);
    }

    /**
     * @see Inflector::hyphenate()
     */
    public static function hyphenate(string $str, string $locale = Inflector::DEFAULT_LOCALE): string
    {
        return Inflector::get($locale)->hyphenate($str);
    }

    /**
     * @see Inflector::humanize()
     */
    public static function humanize(
        string $lower_case_and_underscored_word,
        string $locale = Inflector::DEFAULT_LOCALE
    ): string {
        return Inflector::get($locale)->humanize($lower_case_and_underscored_word);
    }

    /**
     * @see Inflector::titleize()
     */
    public static function titleize(string $str, string $locale = Inflector::DEFAULT_LOCALE): string
    {
        return Inflector::get($locale)->titleize($str);
    }
}
