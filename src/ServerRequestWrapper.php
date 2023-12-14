<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

trait ServerRequestWrapper
{
    private ServerRequestInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    /**
     * @param callable(ServerRequestInterface): static $factory
     */
    protected function setFactory(callable $factory): static
    {
        $this->factory = $factory(...);
        return $this;
    }

    /**
     * @return static&ServerRequestInterface
     */
    private function viaFactory(ServerRequestInterface $message): static
    {
        return $this->factory ? ($this->factory)($message) : $this->setWrapped($message);
    }

    protected function setWrapped(ServerRequestInterface $message): static
    {
        $this->wrapped = $message;
        return $this;
    }

    private function getWrapped(): ServerRequestInterface
    {
        return $this->wrapped ?? throw new \UnexpectedValueException('must set wrapped server request first');
    }

    public function getProtocolVersion(): string
    {
        return $this->getWrapped()->getProtocolVersion();
    }

    public function withProtocolVersion(string $version): ServerRequestInterface
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
     * @return static&ServerRequestInterface
     */
    public function withHeader(string $name, mixed $value): ServerRequestInterface
    {
        return $this->viaFactory($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&ServerRequestInterface
     */
    public function withAddedHeader(string $name, mixed $value): ServerRequestInterface
    {
        return $this->viaFactory($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withoutHeader(string $name): ServerRequestInterface
    {
        return $this->viaFactory($this->getWrapped()->withoutHeader($name));
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
        return $this->viaFactory($this->getWrapped()->withBody($body));
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
        return $this->viaFactory($this->getWrapped()->withRequestTarget($requestTarget));
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
        return $this->viaFactory($this->getWrapped()->withMethod($method));
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
        return $this->viaFactory($this->getWrapped()->withUri($uri, $preserveHost));
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
        return $this->viaFactory($this->getWrapped()->withCookieParams($cookies));
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
        return $this->viaFactory($this->getWrapped()->withQueryParams($query));
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
        return $this->viaFactory($this->getWrapped()->withUploadedFiles($uploadedFiles));
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
        return $this->viaFactory($this->getWrapped()->withParsedBody($data));
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
        return $this->viaFactory($this->getWrapped()->withAttribute($name, $value));
    }

    /**
     * @return static&ServerRequestInterface
     */
    public function withoutAttribute(string $name): ServerRequestInterface
    {
        return $this->viaFactory($this->getWrapped()->withoutAttribute($name));
    }
}
