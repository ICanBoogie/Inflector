<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Inflections;

use ICanBoogie\Inflections;
use ICanBoogie\InflectionsConfigurator;

/**
 * French Inflections.
 *
 * @see http://grammaire.reverso.net/5_5_01_pluriel_des_noms_et_des_adjectifs.shtml
 *
 * @codeCoverageIgnore
 */
final class fr implements InflectionsConfigurator
{
    public static function configure(Inflections $inflections): void
    {
        $inflections
            ->plural('/$/', 's')
            ->singular('/s$/', '')
            ->plural('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)$/', '\1x')
            ->singular('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)x$/', '\1')
            ->plural('/(bleu|émeu|landau|lieu|pneu|sarrau)$/', '\1s')
            ->plural('/al$/', 'aux')
            ->plural('/ail$/', 'ails')
            ->singular('/(journ|chev)aux$/', '\1al')
            ->singular('/ails$/', 'ail')
            ->plural('/(b|cor|ém|gemm|soupir|trav|vant|vitr)ail$/', '\1aux')
            ->singular('/(b|cor|ém|gemm|soupir|trav|vant|vitr)aux$/', '\1ail')
            ->plural('/(s|x|z)$/', '\1')
            ->irregular('monsieur', 'messieurs')
            ->irregular('madame', 'mesdames')
            ->irregular('mademoiselle', 'mesdemoiselles');
    }
}
