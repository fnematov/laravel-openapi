<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Fnematov\LaravelOpenApi\Http\OpenApiController;

Route::group(['as' => 'openapi.'], function () {
    foreach (config('openapi.collections', []) as $name => $config) {
        $uri = Arr::get($config, 'route.uri');

        if (! $uri) {
            continue;
        }

        Route::get($uri, [OpenApiController::class, 'show'])
            ->name($name.'.specification')
            ->defaults('collection', $name)
            ->middleware(Arr::get($config, 'route.middleware'));
    }
});
