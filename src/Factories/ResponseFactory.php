<?php

namespace Fnematov\LaravelOpenApi\Factories;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Fnematov\LaravelOpenApi\Concerns\Referencable;

abstract class ResponseFactory
{
    use Referencable;

    abstract public function build(): Response;
}
