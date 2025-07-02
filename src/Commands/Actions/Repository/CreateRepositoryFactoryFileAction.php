<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Actions\Repository;

use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Action\AbstractCreateFileAction;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Generator\ClassGenerator;

readonly class CreateRepositoryFactoryFileAction extends AbstractCreateFileAction
{
    public function create(): string
    {
        $classGenerator = new ClassGenerator($this->className, $this->namespace);

        $classGenerator->setFunction("function get(): {$this->argumentName}RepositoryInterface {\n{$classGenerator->spaces}return new {$this->argumentName}Repository();\n}")
            ->setImplements(config('service-maker.repositories.map.factory'));

        $this->createDirectoryIfNotExists();

        $this->save($this->classPath, $classGenerator->generate());

        return $this->classPath;
    }
}
