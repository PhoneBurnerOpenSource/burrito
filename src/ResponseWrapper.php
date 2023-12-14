<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

trait ResponseWrapper
{
    private ResponseInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    /**
     * @param callable(ResponseInterface): static $factory
     */
    protected function setFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    /**
     * @return static&ResponseInterface
     */
    private function viaFactory(ResponseInterface $response): static
    {
        $this->factory ??= $this->setWrapped(...);
        return ($this->factory)($response);
    }

    protected function setWrapped(ResponseInterface $message): static
    {
        $this->wrapped = $message;
        return $this;
    }

    private function getWrapped(): ResponseInterface
    {
        return $this->wrapped ?? throw new \UnexpectedValueException('must set wrapped response first');
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
     * @return static&ResponseInterface
     */
    public function withHeader(string $name, mixed $value): ResponseInterface
    {
        return $this->viaFactory($this->getWrapped()->withHeader($name, $value));
    }

    /**
     * @param string|string[] $value
     * @return static&ResponseInterface
     */
    public function withAddedHeader(string $name, mixed $value): ResponseInterface
    {
        return $this->viaFactory($this->getWrapped()->withAddedHeader($name, $value));
    }

    /**
     * @return static&ResponseInterface
     */
    public function withoutHeader(string $name): ResponseInterface
    {
        return $this->viaFactory($this->getWrapped()->withoutHeader($name));
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
        return $this->viaFactory($this->getWrapped()->withBody($body));
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
        return $this->viaFactory($this->getWrapped()->withStatus($code, $reasonPhrase));
    }

    public function getReasonPhrase(): string
    {
        return $this->getWrapped()->getReasonPhrase();
    }
}
