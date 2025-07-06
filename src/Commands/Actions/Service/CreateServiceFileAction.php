<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Actions\Service;

use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Action\AbstractCreateFileAction;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Generator\ClassGenerator;
use Lowel\LaravelServiceMaker\Exceptions\FileDuplicatedException;

readonly class CreateServiceFileAction extends AbstractCreateFileAction
{
    /**
     * @throws FileDuplicatedException
     * @throws \Exception
     */
    public function create(): string
    {
        $classGenerator = new ClassGenerator($this->className, $this->namespace);

        $classGenerator->setExtends(config('service-maker.services.map.abstract'))
            ->setImplements("{$this->namespace}\\{$this->className}Interface");

        $this->createDirectoryIfNotExists();
        $this->save($this->classPath, $classGenerator->generate());

        return $this->classPath;
    }
}
