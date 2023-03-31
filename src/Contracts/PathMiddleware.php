<?php

namespace Fnematov\LaravelOpenApi\Contracts;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use Fnematov\LaravelOpenApi\RouteInformation;

interface PathMiddleware
{
    public function before(RouteInformation $routeInformation): void;

    public function after(PathItem $pathItem): PathItem;
}
