<?php

namespace Fnematov\LaravelOpenApi\Builders\Components;

use Fnematov\LaravelOpenApi\Contracts\Reusable;
use Fnematov\LaravelOpenApi\Factories\CallbackFactory;
use Fnematov\LaravelOpenApi\Generator;

class CallbacksBuilder extends Builder
{
    public function build(string $collection = Generator::COLLECTION_DEFAULT): array
    {
        return $this->getAllClasses($collection)
            ->filter(static function ($class) {
                return
                    is_a($class, CallbackFactory::class, true) &&
                    is_a($class, Reusable::class, true);
            })
            ->map(static function ($class) {
                /** @var CallbackFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values()
            ->toArray();
    }
}
