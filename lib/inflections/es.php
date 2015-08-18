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
 * Spanish inflections.
 *
 * @param Inflections $inflect
 *
 * @see http://www.studyspanish.com/lessons/plnoun.htm
 * @see http://spanish.about.com/cs/writing/a/writing_plurals.htm
 */
//@codeCoverageIgnoreStart
return function(Inflections $inflect) {

	$inflect
	->plural('/$/', 's')
	->plural('/([^aeéiou])$/i', '\1es')
	->plural('/([aeiou]s)$/i', '\1')
	->plural('/z$/i', 'ces')
	->plural('/á([sn])$/i', 'a\1es')
	->plural('/é([sn])$/i', 'e\1es')
	->plural('/í([sn])$/i', 'i\1es')
	->plural('/ó([sn])$/i', 'o\1es')
	->plural('/ú([sn])$/i', 'u\1es')

	->singular('/s$/', '')
	->singular('/es$/', '')
	->singular('/ces$/', 'z')
	->singular('/iones$/', 'ión')
	->singular('/ereses$/', 'erés')

	->irregular('el', 'los')
	->irregular('lunes', 'lunes')
	->irregular('rompecabezas', 'rompecabezas')
	->irregular('crisis', 'crisis')
	->irregular('papá', 'papás')
	->irregular('mamá', 'mamás')
	->irregular('sofá', 'sofás')
	// because 'mes' is considered already a plural
	->irregular('mes', 'meses');
};
//@codeCoverageIgnoreEnd
