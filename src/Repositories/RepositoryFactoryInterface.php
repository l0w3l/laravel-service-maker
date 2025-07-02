<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Repositories;

interface RepositoryFactoryInterface
{
    public function get(): RepositoryInterface;
}
