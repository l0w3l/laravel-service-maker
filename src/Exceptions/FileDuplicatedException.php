<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Exceptions;

use Exception;

class FileDuplicatedException extends Exception
{
    public function __construct(string $path)
    {
        parent::__construct("File duplicated: {$path}");
    }
}
