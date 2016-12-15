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
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	function downcase($str)
	{
		return mb_strtolower($str);
	}
}

if (!function_exists(__NAMESPACE__ . '\upcase'))
{
	/**
	 * Returns an uppercase string.
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	function upcase($str)
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
	 * @param string $str
	 * @param bool $preserve_str_end Whether the string end should be preserved or downcased.
	 *
	 * @return string
	 */
	function capitalize($str, $preserve_str_end = false)
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
 *
 * @param string $word
 * @param string $locale Locale identifier.
 *
 * @return string
 */
function pluralize($word, $locale = INFLECTOR_DEFAULT_LOCALE)
{
	return Inflector::get($locale)->pluralize($word);
}

/**
 * Forwards calls to `Inflector::get()->singularize()`.
 *
 * @param string $word
 * @param string $locale Locale identifier.
 *
 * @return string
 */
function singularize($word, $locale = INFLECTOR_DEFAULT_LOCALE)
{
	return Inflector::get($locale)->singularize($word);
}

/**
 * Forwards calls to `Inflector::get()->camelize()`.
 *
 * @param string $str
 * @param bool $uppercase_first_letter
 * @param string $locale Locale identifier.
 *
 * @return string
 */
function camelize($str, $uppercase_first_letter = false, $locale = INFLECTOR_DEFAULT_LOCALE)
{
	return Inflector::get($locale)->camelize($str, $uppercase_first_letter);
}

/**
 * Forwards calls to `Inflector::get()->underscore()`.
 *
 * @param string $camel_cased_word
 * @param string $locale Locale identifier.
 *
 * @return string
 */
function underscore($camel_cased_word, $locale = INFLECTOR_DEFAULT_LOCALE)
{
	return Inflector::get($locale)->underscore($camel_cased_word);
}

/**
 * Forwards calls to `Inflector::get()->hyphenate()`.
 *
 * @param string $str
 * @param string $locale Locale identifier.
 *
 * @return string
 */
function hyphenate($str, $locale = INFLECTOR_DEFAULT_LOCALE)
{
	return Inflector::get($locale)->hyphenate($str);
}

/**
 * Forwards calls to `Inflector::get()->humanize()`.
 *
 * @param string $lower_case_and_underscored_word
 * @param string $locale Locale identifier.
 *
 * @return string
 */
function humanize($lower_case_and_underscored_word, $locale = INFLECTOR_DEFAULT_LOCALE)
{
	return Inflector::get($locale)->humanize($lower_case_and_underscored_word);
}

/**
 * Forwards calls to `Inflector::get()->titleize()`.
 *
 * @param string $str
 * @param string $locale Locale identifier.
 *
 * @return string
 */
function titleize($str, $locale = INFLECTOR_DEFAULT_LOCALE)
{
	return Inflector::get($locale)->titleize($str);
}
