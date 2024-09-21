<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor', 'docker'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        'trailing_comma_in_multiline' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
