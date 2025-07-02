<?php

use Lowel\LaravelServiceMaker\Repositories\AbstractRepository;
use Lowel\LaravelServiceMaker\Repositories\RepositoryFactoryInterface;
use Lowel\LaravelServiceMaker\Repositories\RepositoryInterface;
use Lowel\LaravelServiceMaker\Repositories\SingletonRepositoryInterface;
use Lowel\LaravelServiceMaker\Services\AbstractService;
use Lowel\LaravelServiceMaker\Services\ServiceFactoryInterface;
use Lowel\LaravelServiceMaker\Services\ServiceInterface;
use Lowel\LaravelServiceMaker\Services\SingletonServiceInterface;

return [
    'spaces' => 4,

    'services' => [
        'folder' => app_path('Services'),
        'map' => [
            'abstract' => AbstractService::class,
            'interface' => ServiceInterface::class,
            'factory' => ServiceFactoryInterface::class,
            'singleton' => SingletonServiceInterface::class,
        ],
    ],
    'repositories' => [
        'folder' => app_path('Repositories'),
        'map' => [
            'abstract' => AbstractRepository::class,
            'interface' => RepositoryInterface::class,
            'factory' => RepositoryFactoryInterface::class,
            'singleton' => SingletonRepositoryInterface::class,
        ],
    ],
];
