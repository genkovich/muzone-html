<?php
require_once __DIR__ . '/vendor/autoload.php';

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP82Migration' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
    ])
    ->setFinder($finder)
;
