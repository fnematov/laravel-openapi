<?php

namespace Fnematov\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Fnematov\LaravelOpenApi\Attributes\RequestBody as RequestBodyAttribute;
use Fnematov\LaravelOpenApi\Contracts\Reusable;
use Fnematov\LaravelOpenApi\Factories\RequestBodyFactory;
use Fnematov\LaravelOpenApi\RouteInformation;

class RequestBodyBuilder
{
    public function build(RouteInformation $route): ?RequestBody
    {
        /** @var RequestBodyAttribute|null $requestBody */
        $requestBody = $route->actionAttributes->first(static fn (object $attribute) => $attribute instanceof RequestBodyAttribute);

        if ($requestBody) {
            /** @var RequestBodyFactory $requestBodyFactory */
            $requestBodyFactory = app($requestBody->factory);

            $requestBody = $requestBodyFactory->build();

            if ($requestBodyFactory instanceof Reusable) {
                return RequestBody::ref('#/components/requestBodies/'.$requestBody->objectId);
            }
        }

        return $requestBody;
    }
}
