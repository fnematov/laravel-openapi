<?php

namespace Fnematov\LaravelOpenApi\Builders\Components;

use Fnematov\LaravelOpenApi\Contracts\Reusable;
use Fnematov\LaravelOpenApi\Factories\RequestBodyFactory;
use Fnematov\LaravelOpenApi\Generator;

class RequestBodiesBuilder extends Builder
{
    public function build(string $collection = Generator::COLLECTION_DEFAULT): array
    {
        return $this->getAllClasses($collection)
            ->filter(static function ($class) {
                return
                    is_a($class, RequestBodyFactory::class, true) &&
                    is_a($class, Reusable::class, true);
            })
            ->map(static function ($class) {
                /** @var RequestBodyFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values()
            ->toArray();
    }
}
