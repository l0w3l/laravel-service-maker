<?php

namespace Lowel\LaravelServiceMaker\Commands;

use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\AbstractMakeFilesCommand;
use Lowel\LaravelServiceMaker\Commands\Actions\Repository\CreateRepositoryFactoryFileAction;
use Lowel\LaravelServiceMaker\Commands\Actions\Repository\CreateRepositoryFileAction;
use Lowel\LaravelServiceMaker\Commands\Actions\Repository\CreateRepositoryInterfaceFileAction;
use Lowel\LaravelServiceMaker\Commands\Files\Repository\RepositoryFactoryFileMetadata;
use Lowel\LaravelServiceMaker\Commands\Files\Repository\RepositoryFileMetadata;
use Lowel\LaravelServiceMaker\Commands\Files\Repository\RepositoryInterfaceFileMetadata;

class MakeRepository extends AbstractMakeFilesCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lowel:make:repository {name : name of repository} {--s|singleton : singleton option}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    public function getActions(string $argument): array
    {
        return [
            new CreateRepositoryInterfaceFileAction(new RepositoryInterfaceFileMetadata, $argument, $this->option('singleton')),
            new CreateRepositoryFileAction(new RepositoryFileMetadata, $argument),
            new CreateRepositoryFactoryFileAction(new RepositoryFactoryFileMetadata, $argument),
        ];
    }
}
