<?php

namespace PhoneBurnerTest\Http\Message\Fixture;

use PhoneBurner\Http\Message\StreamWrapper;
use Psr\Http\Message\StreamInterface;

class StreamWrapperFixture implements StreamInterface
{
    use StreamWrapper;

    public function __construct(StreamInterface $stream = null)
    {
        if (null !== $stream) {
            $this->setStream($stream);
        }
    }
}