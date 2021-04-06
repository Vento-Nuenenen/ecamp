<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR2' => true,
];

$finder = Finder::create()
            ->in('src')
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true);

return Config::create()
        ->setFinder($finder)
        ->setRules($rules)
        ->setRiskyAllowed(true)
        ->setUsingCache(true);
