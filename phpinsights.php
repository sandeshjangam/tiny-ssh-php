<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal", "wordpress"
    |
    */

    'preset' => 'default',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | This options allow to add hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    | Supported: "textmate", "macvim", "emacs", "sublime", "phpstorm",
    | "atom", "vscode".
    |
    | If you have another IDE that is not in this list but which provide an
    | url-handler, you could fill this config with a pattern like this:
    |
    | myide://open?url=file://%f&line=%l
    |
    */

    'ide' => null,

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind, that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'exclude' => [
        //  'path/to/directory-or-file'
    ],

    'add' => [
        //  ExampleMetric::class => [
        //      ExampleInsight::class,
        //  ]
    ],

    'remove' => [
        DisallowEmptySniff::class, // Allow empty method use
    ],

    'config' => [
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
    */

    'requirements' => [
        'min-quality' => 100,
        // 'min-complexity' => 0,
        'min-architecture' => 100,
        'min-style' => 100,
        // 'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analysis. This is optional, don't provide it and the tool will guess
    | the max core number available. It accepts null value or integer > 0.
    |
    */

    'threads' => null,

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    | Here you may adjust the timeout (in seconds) for PHPInsights to run before
    | a ProcessTimedOutException is thrown.
    | This accepts an int > 0. Default is 60 seconds, which is the default value
    | of Symfony's setTimeout function.
    |
    */

    'timeout' => 60,
];