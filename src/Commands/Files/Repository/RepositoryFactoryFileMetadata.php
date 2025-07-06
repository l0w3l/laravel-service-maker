<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Files\Repository;

use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Stub\FileMetadataInterface;

final readonly class RepositoryFactoryFileMetadata implements FileMetadataInterface
{
    public function getPath(): string
    {
        return app_path('/Repositories');
    }

    public function getNamespace(): string
    {
        return 'App\\Repositories';
    }

    public function convertInClassName(string $argumentName): string
    {
        return "{$argumentName}RepositoryFactory";
    }
}
