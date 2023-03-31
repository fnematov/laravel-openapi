<?php

namespace Fnematov\LaravelOpenApi\Factories;

use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Fnematov\LaravelOpenApi\Concerns\Referencable;

abstract class RequestBodyFactory
{
    use Referencable;

    abstract public function build(): RequestBody;
}
