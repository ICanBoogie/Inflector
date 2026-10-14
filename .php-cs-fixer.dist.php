<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRules([
        '@PSR12' => true,
        'function_declaration' => [ 'closure_function_spacing' => 'one', 'closure_fn_spacing' => 'none' ],
        'visibility_required' => [ 'elements' => [ 'property', 'method', 'const' ] ],
    ])
    ->setFinder(
        (new Finder())
            ->in([ __DIR__ . '/lib', __DIR__ . '/tests' ])
            ->exclude('sandbox')
    );
