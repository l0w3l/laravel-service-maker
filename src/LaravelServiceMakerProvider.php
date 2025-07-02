<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker;

use Composer\ClassMapGenerator\ClassMapGenerator;
use Lowel\LaravelServiceMaker\Commands\MakeRepository;
use Lowel\LaravelServiceMaker\Commands\MakeService;
use Lowel\LaravelServiceMaker\Repositories\RepositoryFactoryInterface;
use Lowel\LaravelServiceMaker\Repositories\RepositoryInterface;
use Lowel\LaravelServiceMaker\Repositories\SingletonRepositoryInterface;
use Lowel\LaravelServiceMaker\Services\ServiceFactoryInterface;
use Lowel\LaravelServiceMaker\Services\ServiceInterface;
use Lowel\LaravelServiceMaker\Services\SingletonServiceInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Throwable;

class LaravelServiceMakerProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('service-maker')
            ->hasConfigFile()
            ->hasCommands([
                MakeRepository::class,
                MakeService::class,
            ]);
    }

    /**
     * @throws ReflectionException
     * @throws InvalidPackage
     */
    public function register(): void
    {
        parent::register();

        $this->bindManyServices(
            $this->getServiceInterfaces()
        );

        $this->bindManyRepositories(
            $this->getRepositoryInterfaces()
        );
    }

    /**
     * @param  array<class-string<ServiceInterface>>  $services
     *
     * @throws ReflectionException
     */
    public function bindManyServices(array $services): void
    {
        foreach ($services as $service) {
            $this->bindService($service);
        }
    }

    /**
     * @param  array<class-string<RepositoryInterface>>  $repositories
     *
     * @throws ReflectionException
     */
    public function bindManyRepositories(array $repositories): void
    {
        foreach ($repositories as $repositoryInterfaceName) {
            $this->bindRepository($repositoryInterfaceName);
        }
    }

    /**
     * @param  class-string<ServiceInterface>  $serviceInterfaceName  - service interface name
     *
     * @throws ReflectionException
     */
    public function bindService(string $serviceInterfaceName): void
    {
        $serviceFactoryClassName = str_replace('Interface', 'Factory', $serviceInterfaceName);
        /** @var ServiceFactoryInterface $serviceFactory */
        $serviceFactory = new $serviceFactoryClassName;

        $reflectionClass = new ReflectionClass($serviceInterfaceName);

        if ($reflectionClass->implementsInterface(SingletonServiceInterface::class)) {
            $this->app->singleton($serviceInterfaceName, fn ($_, $params) => $serviceFactory->get($params));
        } else {
            $this->app->bind($serviceInterfaceName, fn ($_, $params) => $serviceFactory->get($params));
        }

    }

    /**
     * @param  string  $repositoryInterfaceName  - repository interface name
     *
     * @throws ReflectionException
     */
    public function bindRepository(string $repositoryInterfaceName): void
    {
        $repositoryFactoryClassName = str_replace('Interface', 'Factory', $repositoryInterfaceName);
        /** @var RepositoryFactoryInterface $repositoryFactory */
        $repositoryFactory = new $repositoryFactoryClassName;

        $reflectionClass = new ReflectionClass($repositoryInterfaceName);

        if ($reflectionClass->implementsInterface(SingletonRepositoryInterface::class)) {
            $this->app->singleton($repositoryInterfaceName, fn ($_, $params) => $repositoryFactory->get($params));
        } else {
            $this->app->bind($repositoryInterfaceName, fn ($_, $params) => $repositoryFactory->get($params));
        }
    }

    /**
     * @return array<class-string<ServiceInterface>>
     */
    public function getServiceInterfaces(): array
    {
        return $this->getObjectsNamespacesBy(
            config('service-maker.services.folder', app_path('Services')),
            fn (ReflectionClass $class) => $class->isInterface() && str_contains($class->getName(), 'ServiceInterface')
        );
    }

    /**
     * @return array<class-string<RepositoryInterface>>
     */
    public function getRepositoryInterfaces(): array
    {
        return $this->getObjectsNamespacesBy(
            config('service-maker.repositories.folder', app_path('Repositories')),
            fn (ReflectionClass $class) => $class->isInterface() && str_contains($class->getName(), 'RepositoryInterface')
        );
    }

    /**
     * @param  ?callable(ReflectionClass): bool  $condition
     */
    public function getObjectsNamespacesBy(string $basePath, ?callable $condition = null): array
    {
        $namespaces = [];
        $classMap = [];

        try {
            $classMap = ClassMapGenerator::createMap($basePath);
        } catch (RuntimeException $e) {
            // ...
        }

        foreach ($classMap as $class => $path) {
            try {
                $reflection = new ReflectionClass($class);
                if (($condition && $condition($reflection)) ?? true) {
                    $namespaces[] = $class;
                }
            } catch (Throwable $e) {
                continue;
            }
        }

        return $namespaces;
    }
}
