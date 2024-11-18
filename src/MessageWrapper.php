<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @phpstan-require-implements MessageInterface
 */
trait MessageWrapper
{
    private MessageInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    abstract protected function wrap(MessageInterface $message): static;

    protected function setWrapped(MessageInterface $message): static
    {
        $this->wrapped = $message;
        return $this;
    }

    protected function setWrappedFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    public function getWrapped(): MessageInterface
    {
        return $this->wrapped ??=
            $this->factory instanceof \Closure
                ? ($this->factory)()
                : throw new \UnexpectedValueException('must set wrapped message first');
    }

    public function getProtocolVersion(): string
    {
        return $this->getWrapped()->getProtocolVersion();
    }

    /**
     * @return static&MessageInterface
     */
    public function withProtocolVersion(string $version): MessageInterface
    {
        return $this->wrap($this->getWrapped()->withProtocolVersion($version));
    }

    public function getHeaders(): array
    {
        return $this->getWrapped()->getHeaders();
    }

    public function hasHeader(string $name): bool
    {
        return $this->getWrapped()->hasHeader($name);
    }

    public function getHeader(string $name): array
    {
        return $this->getWrapped()->getHeader($name);
    }

    public function getHeaderLine(string $name): string
    {
        return $this->getWrapped()->getHeaderLine($name);
    }

    /**
     * @param string|string[] $value
     * @return static&MessageInterface
     */
    public function withHeader(string $name, mixed $value): MessageInterface
    {
        return $this->wrap($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&MessageInterface
     */
    public function withAddedHeader(string $name, mixed $value): MessageInterface
    {
        return $this->wrap($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&MessageInterface
     */
    public function withoutHeader(string $name): MessageInterface
    {
        return $this->wrap($this->getWrapped()->withoutHeader($name));
    }

    public function getBody(): StreamInterface
    {
        return $this->getWrapped()->getBody();
    }

    /**
     * @return static&MessageInterface
     */
    public function withBody(StreamInterface $body): MessageInterface
    {
        return $this->wrap($this->getWrapped()->withBody($body));
    }
}
