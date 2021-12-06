<?php

$finder = (new PhpCsFixer\Finder())
    ->in(dirname(__DIR__, 2))
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'phpdoc_to_comment' => false,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
