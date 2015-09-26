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
 * English inflections.
 *
 * @param Inflections $inflect
 */
//@codeCoverageIgnoreStart
return function(Inflections $inflect) {

	$inflect
		->plural('/^(.*)$/i', '\1s')
		->plural('/^(.*)ão$/i', '\1ões')
		->plural('/^(.*)(r|s|z)$/i', '\1\2es')
		->plural('/^(.*)(a|e|o|u)l$/i', '\1\2is')
		->plural('/^(.*)il$/i', '\1\2is')
		->plural('/^(.*)(m|n)$/i', '\1ns')
		->irregular('abdomen', 'abdomens')
		->irregular('alemão', 'alemães')
		->irregular('artesã', 'artesãos')
		->irregular('ás', 'áses')
		->irregular('bencão', 'bencãos')
		->irregular('cão', 'cães')
		->irregular('campus', 'campi')
		->irregular('capelão', 'capelães')
		->irregular('capitão', 'capitães')
		->irregular('chão', 'chãos')
		->irregular('charlatão', 'charlatães')
		->irregular('cidadão', 'cidadãos')
		->irregular('consul', 'consules')
		->irregular('cristão', 'cristãos')
		->irregular('difícil', 'difíceis')
		->irregular('email', 'emails')
		->irregular('escrivão', 'escrivães')
		->irregular('fóssil', 'fósseis')
		->irregular('germens', 'germen')
		->irregular('grão', 'grãos')
		->irregular('hífen', 'hífens')
		->irregular('irmão', 'irmãos')
		->irregular('liquens', 'liquen')
		->irregular('mal', 'males')
		->irregular('mão', 'mãos')
		->irregular('orfão', 'orfãos')
		->irregular('país', 'países')
		->irregular('pai', 'pais')
		->irregular('pão', 'pães')
		->irregular('projétil', 'projéteis')
		->irregular('réptil', 'répteis')
		->irregular('sacristão', 'sacristães')
		->irregular('sotão', 'sotãos')
		->irregular('tabelião', 'tabeliães')
		->irregular('gás', 'gases')
		->irregular('álcool', 'álcoois')
		// http://easenglish.net/Files/Grammar/uncountable%20words.pdf
		->uncountable(explode(' ', 'atlas lapis onibus pires virus status'));

};
//@codeCoverageIgnoreEnd
