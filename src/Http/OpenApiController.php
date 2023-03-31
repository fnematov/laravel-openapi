<?php

namespace Fnematov\LaravelOpenApi\Http;

use GoldSpecDigital\ObjectOrientedOAS\OpenApi;
use Fnematov\LaravelOpenApi\Generator;

class OpenApiController
{
    public function show(Generator $generator, string $collection = 'default'): OpenApi
    {
        return $generator->generate($collection);
    }
}
