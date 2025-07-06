<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Files\Service;

use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Stub\FileMetadataInterface;

final readonly class ServiceInterfaceFileMetadata implements FileMetadataInterface
{
    public function convertInClassName(string $argumentName): string
    {
        return "{$argumentName}ServiceInterface";
    }

    public function getPath(): string
    {
        return app_path('/Services');
    }

    public function getNamespace(): string
    {
        return 'App\\Services';
    }
}
