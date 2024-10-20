<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @phpstan-require-implements RequestInterface
 */
trait RequestWrapper
{
    private RequestInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    abstract protected function wrap(RequestInterface $message): static;

    protected function setWrapped(RequestInterface $message): static
    {
        $this->wrapped = $message;
        return $this;
    }

    protected function setWrappedFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    public function getWrapped(): RequestInterface
    {
        return $this->wrapped ??=
            $this->factory instanceof \Closure
                ? ($this->factory)()
                : throw new \UnexpectedValueException('must set wrapped request first');
    }

    public function getProtocolVersion(): string
    {
        return $this->getWrapped()->getProtocolVersion();
    }

    /**
     * @return static&RequestInterface
     */
    public function withProtocolVersion(string $version): RequestInterface
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
     * @return static&RequestInterface
     */
    public function withHeader(string $name, mixed $value): RequestInterface
    {
        return $this->wrap($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&RequestInterface
     */
    public function withAddedHeader(string $name, mixed $value): RequestInterface
    {
        return $this->wrap($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&RequestInterface
     */
    public function withoutHeader(string $name): RequestInterface
    {
        return $this->wrap($this->getWrapped()->withoutHeader($name));
    }

    public function getBody(): StreamInterface
    {
        return $this->getWrapped()->getBody();
    }

    /**
     * @return static&RequestInterface
     */
    public function withBody(StreamInterface $body): RequestInterface
    {
        return $this->wrap($this->getWrapped()->withBody($body));
    }

    public function getRequestTarget(): string
    {
        return $this->getWrapped()->getRequestTarget();
    }

    /**
     * @return static&RequestInterface
     */
    public function withRequestTarget(string $requestTarget): RequestInterface
    {
        return $this->wrap($this->getWrapped()->withRequestTarget($requestTarget));
    }

    public function getMethod(): string
    {
        return $this->getWrapped()->getMethod();
    }

    /**
     * @return static&RequestInterface
     */
    public function withMethod(string $method): RequestInterface
    {
        return $this->wrap($this->getWrapped()->withMethod($method));
    }

    public function getUri(): UriInterface
    {
        return $this->getWrapped()->getUri();
    }

    /**
     * @return static&RequestInterface
     */
    public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
    {
        return $this->wrap($this->getWrapped()->withUri($uri, $preserveHost));
    }
}
