<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\Fixture;

use PhoneBurner\Http\Message\StreamWrapper;
use Psr\Http\Message\StreamInterface;

class StreamWrapperFixture implements StreamInterface
{
    use StreamWrapper;

    public function __construct(StreamInterface|null $stream = null)
    {
        if ($stream instanceof StreamInterface) {
            $this->setWrapped($stream);
        }
    }
}
