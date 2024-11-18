<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @phpstan-require-implements ResponseInterface
 */
trait ResponseWrapper
{
    private ResponseInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    abstract protected function wrap(ResponseInterface $response): static;

    protected function setWrapped(ResponseInterface $response): static
    {
        $this->wrapped = $response;
        return $this;
    }

    protected function setWrappedFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    public function getWrapped(): ResponseInterface
    {
        return $this->wrapped ??=
            $this->factory instanceof \Closure
                ? ($this->factory)()
                : throw new \UnexpectedValueException('must set response message first');
    }

    public function getProtocolVersion(): string
    {
        return $this->getWrapped()->getProtocolVersion();
    }

    /**
     * @return static&ResponseInterface
     */
    public function withProtocolVersion(string $version): ResponseInterface
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
     * @return static&ResponseInterface
     */
    public function withHeader(string $name, mixed $value): ResponseInterface
    {
        return $this->wrap($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&ResponseInterface
     */
    public function withAddedHeader(string $name, mixed $value): ResponseInterface
    {
        return $this->wrap($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&ResponseInterface
     */
    public function withoutHeader(string $name): ResponseInterface
    {
        return $this->wrap($this->getWrapped()->withoutHeader($name));
    }

    public function getBody(): StreamInterface
    {
        return $this->getWrapped()->getBody();
    }

    /**
     * @return static&ResponseInterface
     */
    public function withBody(StreamInterface $body): ResponseInterface
    {
        return $this->wrap($this->getWrapped()->withBody($body));
    }

    public function getStatusCode(): int
    {
        return $this->getWrapped()->getStatusCode();
    }

    /**
     * @return static&ResponseInterface
     */
    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->wrap($this->getWrapped()->withStatus($code, $reasonPhrase));
    }

    public function getReasonPhrase(): string
    {
        return $this->getWrapped()->getReasonPhrase();
    }
}
