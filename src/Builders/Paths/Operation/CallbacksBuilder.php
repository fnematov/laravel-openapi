<?php

namespace Fnematov\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use Fnematov\LaravelOpenApi\Attributes\Callback as CallbackAttribute;
use Fnematov\LaravelOpenApi\Contracts\Reusable;
use Fnematov\LaravelOpenApi\RouteInformation;

class CallbacksBuilder
{
    public function build(RouteInformation $route): array
    {
        return $route->actionAttributes
            ->filter(static fn (object $attribute) => $attribute instanceof CallbackAttribute)
            ->map(static function (CallbackAttribute $attribute) {
                $factory = app($attribute->factory);
                $pathItem = $factory->build();

                if ($factory instanceof Reusable) {
                    return PathItem::ref('#/components/callbacks/'.$pathItem->objectId);
                }

                return $pathItem;
            })
            ->values()
            ->toArray();
    }
}
