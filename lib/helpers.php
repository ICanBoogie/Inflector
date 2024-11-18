<?php

namespace ICanBoogie;

// Avoid conflicts with ICanBoogie/Common
if (!function_exists(__NAMESPACE__ . '\downcase')) {
    /**
     * @see StaticInflector::downcase()
     */
    function downcase(string $str): string
    {
        return StaticInflector::downcase($str);
    }
}

// Avoid conflicts with ICanBoogie/Common
if (!function_exists(__NAMESPACE__ . '\upcase')) {
    /**
     * @see StaticInflector::upcase()
     */
    function upcase(string $str): string
    {
        return StaticInflector::upcase($str);
    }
}

// Avoid conflicts with ICanBoogie/Common
if (!function_exists(__NAMESPACE__ . '\capitalize')) {
    /**
     * @see StaticInflector::capitalize()
     */
    function capitalize(string $str, bool $preserve_str_end = false): string
    {
        return StaticInflector::capitalize($str, $preserve_str_end);
    }
}

/**
 * @see StaticInflector::pluralize()
 */
function pluralize(string $word, string $locale = Inflector::DEFAULT_LOCALE): string
{
    return StaticInflector::pluralize($word, $locale);
}

/**
 * @see StaticInflector::singularize()
 */
function singularize(string $word, string $locale = Inflector::DEFAULT_LOCALE): string
{
    return StaticInflector::singularize($word, $locale);
}

/**
 * @see StaticInflector::camelize()
 */
function camelize(
    string $str,
    bool $uppercase_first_letter = false,
    string $locale = Inflector::DEFAULT_LOCALE
): string {
    return StaticInflector::camelize($str, $uppercase_first_letter, $locale);
}

/**
 * @see StaticInflector::underscore()
 */
function underscore(string $camel_cased_word, string $locale = Inflector::DEFAULT_LOCALE): string
{
    return StaticInflector::underscore($camel_cased_word, $locale);
}

/**
 * @see StaticInflector::hyphenate()
 */
function hyphenate(string $str, string $locale = Inflector::DEFAULT_LOCALE): string
{
    return StaticInflector::hyphenate($str, $locale);
}

/**
 * @see StaticInflector::humanize()
 */
function humanize(string $lower_case_and_underscored_word, string $locale = Inflector::DEFAULT_LOCALE): string
{
    return StaticInflector::humanize($lower_case_and_underscored_word, $locale);
}

/**
 * @see StaticInflector::titleize()
 */
function titleize(string $str, string $locale = Inflector::DEFAULT_LOCALE): string
{
    return StaticInflector::titleize($str, $locale);
}
