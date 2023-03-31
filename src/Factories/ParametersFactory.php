<?php

namespace Fnematov\LaravelOpenApi\Factories;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use Fnematov\LaravelOpenApi\Concerns\Referencable;

abstract class ParametersFactory
{
    use Referencable;

    /**
     * @return Parameter[]
     */
    abstract public function build(): array;
}
