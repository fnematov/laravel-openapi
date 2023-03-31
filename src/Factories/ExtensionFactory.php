<?php

namespace Fnematov\LaravelOpenApi\Factories;

abstract class ExtensionFactory
{
    abstract public function key(): string;

    /**
     * @return string|null|array
     */
    abstract public function value();
}
