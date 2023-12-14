<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\Fixture;

use PhoneBurner\Http\Message\MessageWrapper;
use Psr\Http\Message\MessageInterface;

class MessageWrapperFixture implements MessageInterface
{
    use MessageWrapper;

    public function __construct(MessageInterface|null $message = null, callable|null $factory = null)
    {
        if ($message instanceof MessageInterface) {
            $this->setWrapped($message);
        }

        if (null !== $factory) {
            $this->setFactory($factory);
        }
    }
}
