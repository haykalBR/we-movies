<?php

$finder = (new PhpCsFixer\Finder())
    ->in('src')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony'                     => true,
        'array_syntax'                 => ['syntax' => 'short'],
        'blank_line_after_opening_tag' => true,
        'ordered_imports'              => ['sort_algorithm' => 'alpha'],
        'php_unit_construct'           => true,
        'php_unit_strict'              => true,
    ])
    ->setUsingCache(true)
    ->setFinder($finder)
;
