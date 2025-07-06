<?php

use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $filesystem = new Filesystem;

    $filesystem->cleanDirectory(app_path('Repositories'));
});

it('service creation', function () {
    $test = 'Test';

    Artisan::call("lowel:make:repository {$test}");

    expect(app_path("Repositories/{$test}/{$test}RepositoryInterface.php"))->toBeFile()
        ->and(app_path("Repositories/{$test}/{$test}RepositoryFactory.php"))->toBeFile()
        ->and(app_path("Repositories/{$test}/{$test}Repository.php"))->toBeFile();
});
