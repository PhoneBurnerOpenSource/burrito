<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

trait MessageWrapper
{
    private MessageInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    /**
     * @param callable(MessageInterface): static $factory
     */
    protected function setFactory(callable $factory): static
    {
        $this->factory = $factory(...);
        return $this;
    }

    /**
     * @return static&MessageInterface
     */
    private function viaFactory(MessageInterface $message): static
    {
        return $this->factory ? ($this->factory)($message) : $this->setWrapped($message);
    }

    protected function setWrapped(MessageInterface $message): static
    {
        $this->wrapped = $message;
        return $this;
    }

    private function getWrapped(): MessageInterface
    {
        return $this->wrapped ?? throw new \UnexpectedValueException('must set wrapped message first');
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
        return $this->viaFactory($this->getWrapped()->withProtocolVersion($version));
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
        return $this->viaFactory($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&MessageInterface
     */
    public function withAddedHeader(string $name, mixed $value): MessageInterface
    {
        return $this->viaFactory($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&MessageInterface
     */
    public function withoutHeader(string $name): MessageInterface
    {
        return $this->viaFactory($this->getWrapped()->withoutHeader($name));
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
        return $this->viaFactory($this->getWrapped()->withBody($body));
    }
}
