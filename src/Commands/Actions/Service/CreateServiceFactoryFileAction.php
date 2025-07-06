<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Actions\Service;

use Exception;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Action\AbstractCreateFileAction;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Generator\ClassGenerator;
use Lowel\LaravelServiceMaker\Exceptions\FileDuplicatedException;

readonly class CreateServiceFactoryFileAction extends AbstractCreateFileAction
{
    /**
     * @throws FileDuplicatedException
     * @throws Exception
     */
    public function create(): string
    {
        $classGenerator = new ClassGenerator($this->className, $this->namespace);

        $classGenerator->setFunction("function get(): {$this->argumentName}ServiceInterface {\n{$classGenerator->spaces}return new {$this->argumentName}Service();\n}")
            ->setImplements(config('service-maker.services.map.factory'));

        $this->save($this->classPath, $classGenerator->generate());

        $this->createDirectoryIfNotExists();

        return $this->classPath;
    }
}
