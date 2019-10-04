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
return function(Inflections $inflect): void {

	$inflect
	    ->plural('/$/',  's')
	    ->plural('/(s)$/i',  '\1')
	    ->plural('/(z|r)$/i', '\1es')
	    ->plural('/al$/i',  'ais')
	    ->plural('/el$/i',  'eis')
	    ->plural('/ol$/i',  'ois')
	    ->plural('/ul$/i',  'uis')
	    ->plural('/([^aeou])il$/i',  '\1is')
	    ->plural('/m$/i',   'ns')
	    ->plural('/^(japon|escoc|ingl|dinamarqu|fregu|portugu)ês$/i',  '\1eses')
	    ->plural('/^(|g)ás$/i',  '\1ases')
	    ->plural('/ão$/i',  'ões')
	    ->plural('/^(irm|m)ão$/i',  '\1ãos')
		->plural('/^(alem|c|p)ão$/i', '\1ães')

		# Sem acentos...
	    ->plural('/ao$/i',  'oes')
        ->plural('/^(irm|m)ao$/i',  '\1aos')
		->plural('/^(alem|c|p)ao$/i', '\1aes')

	    ->singular('/([^ê])s$/i', '\1')
	    ->singular('/^(á|gá)s$/i', '\1s')
	    ->singular('/(r|z)es$/i', '\1')
	    ->singular('/([^p])ais$/i', '\1al')
	    ->singular('/éis$/i', 'el')
	    ->singular('/eis$/i', 'ei')
	    ->singular('/ois$/i', 'ol')
	    ->singular('/uis$/i', 'ul')
	    ->singular('/(r|t|f|v)is$/i', '\1il')
	    ->singular('/ns$/i', 'm')
	    ->singular('/sses$/i', 'sse')
	    ->singular('/^(.*[^s]s)es$/i', '\1')
	    ->singular('/(ãe|ão|õe)s$/', 'ão')
	    ->singular('/(ae|ao|oe)s$/', 'ao')
	    ->singular('/(japon|escoc|ingl|dinamarqu|fregu|portugu)eses$/i', '\1ês')
		->singular('/^(g|)ases$/i', '\1ás')

		# Irregulares
		->irregular('abdomen', 'abdomens')
		->irregular('alemão', 'alemães')
		->irregular('artesã', 'artesãos')
		->irregular('álcool', 'álcoois')
	    ->irregular("árvore", "árvores")
		->irregular('bencão', 'bencãos')
		->irregular('cão', 'cães')
		->irregular('campus', 'campi')
		->irregular("cadáver", "cadáveres")
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
		->irregular('gás', 'gases')
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

		->uncountable(explode(' ', 'tórax tênis ônibus lápis fênix'))
	;
};
//@codeCoverageIgnoreEnd
