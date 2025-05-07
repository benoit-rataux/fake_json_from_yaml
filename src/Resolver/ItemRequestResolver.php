<?php

namespace App\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ItemRequestResolver implements ValueResolverInterface {

    /**
     * @inheritDoc
     */
    public function resolve(Request          $request,
                            ArgumentMetadata $argument,
    ): iterable {
        // TODO: Implement resolve() method.
    }

}