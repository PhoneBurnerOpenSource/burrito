<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\Fixture;

use PhoneBurner\Http\Message\UriWrapper;
use Psr\Http\Message\UriInterface;

class UriWrapperFixture implements UriInterface
{
    use UriWrapper;

    public function __construct(UriInterface|null $uri = null, callable|null $factory = null)
    {
        if ($uri instanceof UriInterface) {
            $this->setWrapped($uri);
        }

        if (null !== $factory) {
            $this->setFactory($factory);
        }
    }
}
