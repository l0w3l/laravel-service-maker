<?php

use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $filesystem = new Filesystem;

    $filesystem->cleanDirectory(app_path('Services'));
});

it('service creation', function () {
    $test = 'Test';

    Artisan::call("lowel:make:service {$test} -s");

    expect(app_path("Services/{$test}/{$test}ServiceInterface.php"))->toBeFile()
        ->and(app_path("Services/{$test}/{$test}ServiceFactory.php"))->toBeFile()
        ->and(app_path("Services/{$test}/{$test}Service.php"))->toBeFile();
});
