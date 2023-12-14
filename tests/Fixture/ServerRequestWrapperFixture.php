<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\Fixture;

use PhoneBurner\Http\Message\ServerRequestWrapper;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestWrapperFixture implements ServerRequestInterface
{
    use ServerRequestWrapper;

    public function __construct(ServerRequestInterface|null $request = null, callable|null $factory = null)
    {
        if ($request instanceof ServerRequestInterface) {
            $this->setWrapped($request);
        }

        if (null !== $factory) {
            $this->setFactory($factory);
        }
    }
}
