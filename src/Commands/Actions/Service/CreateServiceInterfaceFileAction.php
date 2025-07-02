<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Actions\Service;

use Exception;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Action\AbstractCreateFileAction;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Generator\InterfaceGenerator;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Stub\FileMetadataInterface;
use Lowel\LaravelServiceMaker\Exceptions\FileDuplicatedException;

readonly class CreateServiceInterfaceFileAction extends AbstractCreateFileAction
{
    public bool $singleton;

    public function __construct(FileMetadataInterface $stub, string $argument, bool $singleton = false)
    {
        $this->singleton = $singleton;

        parent::__construct($stub, $argument);
    }

    /**
     * @throws FileDuplicatedException
     * @throws Exception
     */
    public function create(): string
    {
        $interfaceGenerator = new InterfaceGenerator($this->className, $this->namespace);

        $interfaceGenerator->setExtends(config('service-maker.services.map.interface'));

        if ($this->singleton) {
            $interfaceGenerator->setExtends(config('service-maker.services.map.singleton'));
        }

        $this->createDirectoryIfNotExists();
        $this->save($this->classPath, $interfaceGenerator->generate());

        return $this->classPath;
    }
}
