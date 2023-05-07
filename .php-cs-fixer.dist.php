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
        '@PHPUnit84Migration:risky' => true,
        'whitespace_after_comma_in_array' => [
            'ensure_single_space' => true,
        ],
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'increment_style' => ['style' => 'post'],
        'ordered_imports' => true,
        'compact_nullable_typehint' => true,
        'declare_strict_types' => true,
        'class_definition' => ['multi_line_extends_each_single_line' => true],
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'strict_comparison' => true,
        'visibility_required' => ['elements' => ['property', 'method', 'const']],
        'nullable_type_declaration_for_default_null_value' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => ['version', 'link', 'package', 'copyright', 'author'],
        ],
        'native_function_invocation' => ['include' => ['@internal']],
        'mb_str_functions' => true,
        'binary_operator_spaces' => ['operators' => ['|' => null]],

        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_to_comment' => false,
        'phpdoc_summary' => false,
        'phpdoc_no_alias_tag' => false,
        'no_multiline_whitespace_around_double_arrow' => false,
    ])
    ->setFinder($finder)
;
