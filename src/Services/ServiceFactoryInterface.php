<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Services;

use Illuminate\Contracts\Container\BindingResolutionException;

interface ServiceFactoryInterface
{
    /**
     * Return service instance
     *
     * @throws BindingResolutionException
     */
    public function get(array $params = []): object;
}
