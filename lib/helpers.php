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
 * Default inflector locale.
 */
const INFLECTOR_DEFAULT_LOCALE = 'en';

if (!function_exists(__NAMESPACE__ . '\downcase'))
{
	/**
	 * Returns an lowercase string.
	 */
	function downcase(string $str): string
	{
		return mb_strtolower($str);
	}
}

if (!function_exists(__NAMESPACE__ . '\upcase'))
{
	/**
	 * Returns an uppercase string.
	 */
	function upcase(string $str): string
	{
		return mb_strtoupper($str);
	}
}

if (!function_exists(__NAMESPACE__ . '\capitalize'))
{
	/**
	 * Returns a copy of str with the first character converted to uppercase and the
	 * remainder to lowercase.
	 *
	 * @param bool $preserve_str_end Whether the string end should be preserved or downcased.
	 */
	function capitalize(string $str, bool $preserve_str_end = false): string
	{
		$end = mb_substr($str, 1);

		if (!$preserve_str_end) {
			$end = downcase($end);
		}

		return upcase(mb_substr($str, 0, 1)) . $end;
	}
}

/**
 * Forwards calls to `Inflector::get()->pluralize()`.
 */
function pluralize(string $word, string $locale = INFLECTOR_DEFAULT_LOCALE): string
{
	return Inflector::get($locale)->pluralize($word);
}

/**
 * Forwards calls to `Inflector::get()->singularize()`.
 */
function singularize(string $word, string $locale = INFLECTOR_DEFAULT_LOCALE): string
{
	return Inflector::get($locale)->singularize($word);
}

/**
 * Forwards calls to `Inflector::get()->camelize()`.
 */
function camelize(string $str, bool $uppercase_first_letter = false, string $locale = INFLECTOR_DEFAULT_LOCALE): string
{
	return Inflector::get($locale)->camelize($str, $uppercase_first_letter);
}

/**
 * Forwards calls to `Inflector::get()->underscore()`.
 */
function underscore(string $camel_cased_word, string $locale = INFLECTOR_DEFAULT_LOCALE): string
{
	return Inflector::get($locale)->underscore($camel_cased_word);
}

/**
 * Forwards calls to `Inflector::get()->hyphenate()`.
 */
function hyphenate(string $str, string $locale = INFLECTOR_DEFAULT_LOCALE): string
{
	return Inflector::get($locale)->hyphenate($str);
}

/**
 * Forwards calls to `Inflector::get()->humanize()`.
 */
function humanize(string $lower_case_and_underscored_word, string $locale = INFLECTOR_DEFAULT_LOCALE): string
{
	return Inflector::get($locale)->humanize($lower_case_and_underscored_word);
}

/**
 * Forwards calls to `Inflector::get()->titleize()`.
 */
function titleize(string $str, string $locale = INFLECTOR_DEFAULT_LOCALE): string
{
	return Inflector::get($locale)->titleize($str);
}
