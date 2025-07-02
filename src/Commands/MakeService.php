<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands;

use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\AbstractMakeFilesCommand;
use Lowel\LaravelServiceMaker\Commands\Actions\Service\CreateServiceFactoryFileAction;
use Lowel\LaravelServiceMaker\Commands\Actions\Service\CreateServiceFileAction;
use Lowel\LaravelServiceMaker\Commands\Actions\Service\CreateServiceInterfaceFileAction;
use Lowel\LaravelServiceMaker\Commands\Files\Service\ServiceFactoryFileMetadata;
use Lowel\LaravelServiceMaker\Commands\Files\Service\ServiceFileMetadata;
use Lowel\LaravelServiceMaker\Commands\Files\Service\ServiceInterfaceFileMetadata;

class MakeService extends AbstractMakeFilesCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    public function getActions(string $argument): array
    {
        return [
            new CreateServiceFileAction(new ServiceFileMetadata, $argument),
            new CreateServiceInterfaceFileAction(new ServiceInterfaceFileMetadata, $argument),
            new CreateServiceFactoryFileAction(new ServiceFactoryFileMetadata, $argument),
        ];
    }
}
