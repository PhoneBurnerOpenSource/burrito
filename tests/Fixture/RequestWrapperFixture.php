<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\Fixture;

use PhoneBurner\Http\Message\RequestWrapper;
use Psr\Http\Message\RequestInterface;

class RequestWrapperFixture implements RequestInterface
{
    use RequestWrapper;

    public function __construct(RequestInterface|null $request = null, callable|null $factory = null)
    {
        if ($request instanceof RequestInterface) {
            $this->setWrapped($request);
        }

        if (null !== $factory) {
            $this->setFactory($factory);
        }
    }
}
