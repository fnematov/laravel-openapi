<?php

namespace Fnematov\LaravelOpenApi\Concerns;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use InvalidArgumentException;
use Fnematov\LaravelOpenApi\Contracts\Reusable;
use Fnematov\LaravelOpenApi\Factories\CallbackFactory;
use Fnematov\LaravelOpenApi\Factories\ParametersFactory;
use Fnematov\LaravelOpenApi\Factories\RequestBodyFactory;
use Fnematov\LaravelOpenApi\Factories\ResponseFactory;
use Fnematov\LaravelOpenApi\Factories\SchemaFactory;
use Fnematov\LaravelOpenApi\Factories\SecuritySchemeFactory;

trait Referencable
{
    public static function ref(?string $objectId = null): Schema
    {
        $instance = app(static::class);

        if (! $instance instanceof Reusable) {
            throw new InvalidArgumentException('"'.static::class.'" must implement "'.Reusable::class.'" in order to be referencable.');
        }

        $baseRef = null;

        if ($instance instanceof CallbackFactory) {
            $baseRef = '#/components/callbacks/';
        } elseif ($instance instanceof ParametersFactory) {
            $baseRef = '#/components/parameters/';
        } elseif ($instance instanceof RequestBodyFactory) {
            $baseRef = '#/components/requestBodies/';
        } elseif ($instance instanceof ResponseFactory) {
            $baseRef = '#/components/responses/';
        } elseif ($instance instanceof SchemaFactory) {
            $baseRef = '#/components/schemas/';
        } elseif ($instance instanceof SecuritySchemeFactory) {
            $baseRef = '#/components/securitySchemes/';
        }

        return Schema::ref($baseRef.$instance->build()->objectId, $objectId);
    }
}
