<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\Fixture;

use PhoneBurner\Http\Message\ResponseWrapper;
use Psr\Http\Message\ResponseInterface;

class ResponseWrapperFixture implements ResponseInterface
{
    use ResponseWrapper;

    public function __construct(ResponseInterface|null $response = null, callable|null $factory = null)
    {
        if ($response instanceof ResponseInterface) {
            $this->setWrapped($response);
        }

        if (null !== $factory) {
            $this->setFactory($factory);
        }
    }
}
