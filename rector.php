<?php

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;

return RectorConfig::configure()
    // A. whole set
    ->withPreparedSets(typeDeclarations: true)
    // B. or few rules
    ->withRules([
        TypedPropertyFromAssignsRector::class
    ])
    ->withPaths([__DIR__ . '/src', __DIR__ . '/config'])
    ->withPhpVersion(PhpVersion::PHP_83);