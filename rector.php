<?php

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    // A. whole set
    ->withPreparedSets(typeDeclarations: true)
    // B. or few rules
    ->withRules([
        TypedPropertyFromAssignsRector::class,
    ])
    ->withPaths([__DIR__.'/src', __DIR__.'/config'])
    ->withPhpVersion(PhpVersion::PHP_83);
