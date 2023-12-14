<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

trait RequestWrapper
{
    private RequestInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    /**
     * @param callable(RequestInterface): static $factory
     */
    protected function setFactory(callable $factory): static
    {
        $this->factory = $factory(...);
        return $this;
    }

    /**
     * @return static&RequestInterface
     */
    private function viaFactory(RequestInterface $message): static
    {
        return $this->factory ? ($this->factory)($message) : $this->setWrapped($message);
    }

    protected function setWrapped(RequestInterface $message): static
    {
        $this->wrapped = $message;
        return $this;
    }

    private function getWrapped(): RequestInterface
    {
        return $this->wrapped ?? throw new \UnexpectedValueException('must set wrapped request first');
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
     * @return static&RequestInterface
     */
    public function withHeader(string $name, mixed $value): RequestInterface
    {
        return $this->viaFactory($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&RequestInterface
     */
    public function withAddedHeader(string $name, mixed $value): RequestInterface
    {
        return $this->viaFactory($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&RequestInterface
     */
    public function withoutHeader(string $name): RequestInterface
    {
        return $this->viaFactory($this->getWrapped()->withoutHeader($name));
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
        return $this->viaFactory($this->getWrapped()->withBody($body));
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
        return $this->viaFactory($this->getWrapped()->withRequestTarget($requestTarget));
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
        return $this->viaFactory($this->getWrapped()->withMethod($method));
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
        return $this->viaFactory($this->getWrapped()->withUri($uri, $preserveHost));
    }
}
