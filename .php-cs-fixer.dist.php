<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/database',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->exclude([
        'vendor',
        'storage',
        'bootstrap/cache',
    ]);

return (new Config())
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules([
        '@PSR12' => false,
        'blank_line_after_opening_tag' => false,
        'blank_line_after_namespace' => false,
        'no_unused_imports' => true,
        'single_import_per_statement' => true,
        'no_extra_blank_lines' => [
            'tokens' => ['extra', 'return', 'throw', 'curly_brace_block', 'square_brace_block', 'parenthesis_brace_block'],
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'none',
        ],
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'operators' => ['=>' => 'align_single_space'],
        ],
        'phpdoc_align' => false,
        'phpdoc_summary' => false,
        'phpdoc_order' => false,
        'phpdoc_indent' => false,
        'phpdoc_no_empty_return' => false,
        'phpdoc_no_package' => false,
        'phpdoc_scalar' => false,
        'phpdoc_trim' => false,
        'phpdoc_types_order' => false,
        'phpdoc_separation' => false,
        'phpdoc_var_without_name' => false,
]);
