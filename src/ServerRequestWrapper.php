<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @phpstan-require-implements ServerRequestInterface
 */
trait ServerRequestWrapper
{
    private ServerRequestInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    /**
     * @return static&ServerRequestInterface
     */
    abstract protected function wrap(ServerRequestInterface $server_request): static;

    protected function setWrapped(ServerRequestInterface $message): static
    {
        $this->wrapped = $message;
        return $this;
    }

    protected function setWrappedFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    public function getWrapped(): ServerRequestInterface
    {
        return $this->wrapped ??=
            $this->factory instanceof \Closure
                ? ($this->factory)()
                : throw new \UnexpectedValueException('must set wrapped server request first');
    }

    public function getProtocolVersion(): string
    {
        return $this->getWrapped()->getProtocolVersion();
    }

    public function withProtocolVersion(string $version): ServerRequestInterface
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
     * @return static&ServerRequestInterface
     */
    public function withHeader(string $name, mixed $value): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&ServerRequestInterface
     */
    public function withAddedHeader(string $name, mixed $value): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withoutHeader(string $name): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withoutHeader($name));
    }

    public function getBody(): StreamInterface
    {
        return $this->getWrapped()->getBody();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withBody(StreamInterface $body): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withBody($body));
    }

    public function getRequestTarget(): string
    {
        return $this->getWrapped()->getRequestTarget();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withRequestTarget(string $requestTarget): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withRequestTarget($requestTarget));
    }

    public function getMethod(): string
    {
        return $this->getWrapped()->getMethod();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withMethod(string $method): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withMethod($method));
    }

    public function getUri(): UriInterface
    {
        return $this->getWrapped()->getUri();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withUri(UriInterface $uri, bool $preserveHost = false): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withUri($uri, $preserveHost));
    }

    public function getServerParams(): array
    {
        return $this->getWrapped()->getServerParams();
    }

    public function getCookieParams(): array
    {
        return $this->getWrapped()->getCookieParams();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withCookieParams(array $cookies): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withCookieParams($cookies));
    }

    public function getQueryParams(): array
    {
        return $this->getWrapped()->getQueryParams();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withQueryParams(array $query): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withQueryParams($query));
    }

    public function getUploadedFiles(): array
    {
        return $this->getWrapped()->getUploadedFiles();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withUploadedFiles(array $uploadedFiles): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withUploadedFiles($uploadedFiles));
    }

    public function getParsedBody(): array|object|null
    {
        return $this->getWrapped()->getParsedBody();
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withParsedBody(mixed $data): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withParsedBody($data));
    }

    public function getAttributes(): array
    {
        return $this->getWrapped()->getAttributes();
    }

    public function getAttribute(string $name, mixed $default = null): mixed
    {
        return $this->getWrapped()->getAttribute($name, $default);
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withAttribute(string $name, mixed $value): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withAttribute($name, $value));
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withoutAttribute(string $name): ServerRequestInterface
    {
        return $this->wrap($this->getWrapped()->withoutAttribute($name));
    }
}
