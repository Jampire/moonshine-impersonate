<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/lang',
        __DIR__ . '/routes',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

        $rectorConfig->sets([
            LevelSetList::UP_TO_PHP_82,
            SetList::CODE_QUALITY,
            SetList::DEAD_CODE,
            SetList::TYPE_DECLARATION,
//            SetList::EARLY_RETURN,
//            SetList::PSR_4,
            LaravelLevelSetList::UP_TO_LARAVEL_100,
        ]);
};
