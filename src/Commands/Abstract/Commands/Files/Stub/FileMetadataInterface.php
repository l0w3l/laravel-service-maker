<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Stub;

interface FileMetadataInterface
{
    public function convertInClassName(string $argumentName): string;

    public function getPath(): string;

    public function getNamespace(): string;
}
