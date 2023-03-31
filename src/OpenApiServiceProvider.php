<?php

declare(strict_types=1);

namespace Fnematov\LaravelOpenApi;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Fnematov\LaravelOpenApi\Builders\Components\CallbacksBuilder;
use Fnematov\LaravelOpenApi\Builders\Components\RequestBodiesBuilder;
use Fnematov\LaravelOpenApi\Builders\Components\ResponsesBuilder;
use Fnematov\LaravelOpenApi\Builders\Components\SchemasBuilder;
use Fnematov\LaravelOpenApi\Builders\Components\SecuritySchemesBuilder;
use Fnematov\LaravelOpenApi\Builders\ComponentsBuilder;
use Fnematov\LaravelOpenApi\Builders\InfoBuilder;
use Fnematov\LaravelOpenApi\Builders\PathsBuilder;
use Fnematov\LaravelOpenApi\Builders\ServersBuilder;
use Fnematov\LaravelOpenApi\Builders\TagsBuilder;

class OpenApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/openapi.php',
            'openapi'
        );

        $this->app->bind(CallbacksBuilder::class, function () {
            return new CallbacksBuilder($this->getPathsFromConfig('callbacks'));
        });

        $this->app->bind(RequestBodiesBuilder::class, function () {
            return new RequestBodiesBuilder($this->getPathsFromConfig('request_bodies'));
        });

        $this->app->bind(ResponsesBuilder::class, function () {
            return new ResponsesBuilder($this->getPathsFromConfig('responses'));
        });

        $this->app->bind(SchemasBuilder::class, function () {
            return new SchemasBuilder($this->getPathsFromConfig('schemas'));
        });

        $this->app->bind(SecuritySchemesBuilder::class, function () {
            return new SecuritySchemesBuilder($this->getPathsFromConfig('security_schemes'));
        });

        $this->app->singleton(Generator::class, static function (Application $app) {
            $config = config('openapi');

            return new Generator(
                $config,
                $app->make(InfoBuilder::class),
                $app->make(ServersBuilder::class),
                $app->make(TagsBuilder::class),
                $app->make(PathsBuilder::class),
                $app->make(ComponentsBuilder::class)
            );
        });

        $this->commands([
            Console\GenerateCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\CallbackFactoryMakeCommand::class,
                Console\ExtensionFactoryMakeCommand::class,
                Console\ParametersFactoryMakeCommand::class,
                Console\RequestBodyFactoryMakeCommand::class,
                Console\ResponseFactoryMakeCommand::class,
                Console\SchemaFactoryMakeCommand::class,
                Console\SecuritySchemeFactoryMakeCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/openapi.php' => config_path('openapi.php'),
            ], 'openapi-config');
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    private function getPathsFromConfig(string $type): array
    {
        $directories = config('openapi.locations.'.$type, []);

        foreach ($directories as &$directory) {
            $directory = glob($directory, GLOB_ONLYDIR);
        }

        return (new Collection($directories))
            ->flatten()
            ->unique()
            ->toArray();
    }
}
