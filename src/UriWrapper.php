<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\UriInterface;

/**
 * @phpstan-require-implements UriInterface
 */
trait UriWrapper
{
    private UriInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    abstract protected function wrap(UriInterface $uri): static;

    protected function setWrapped(UriInterface $uri): static
    {
        $this->wrapped = $uri;
        return $this;
    }

    protected function setWrappedFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    public function getWrapped(): UriInterface
    {
        return $this->wrapped ??=
            $this->factory instanceof \Closure
                ? ($this->factory)()
                : throw new \UnexpectedValueException('must set wrapped uri first');
    }

    public function getScheme(): string
    {
        return $this->getWrapped()->getScheme();
    }

    public function getAuthority(): string
    {
        return $this->getWrapped()->getAuthority();
    }

    public function getUserInfo(): string
    {
        return $this->getWrapped()->getUserInfo();
    }

    public function getHost(): string
    {
        return $this->getWrapped()->getHost();
    }

    public function getPort(): int|null
    {
        return $this->getWrapped()->getPort();
    }

    public function getPath(): string
    {
        return $this->getWrapped()->getPath();
    }

    public function getQuery(): string
    {
        return $this->getWrapped()->getQuery();
    }

    public function getFragment(): string
    {
        return $this->getWrapped()->getFragment();
    }

    /**
     * @return static&UriInterface
     */
    public function withScheme(string $scheme): UriInterface
    {
        return $this->wrap($this->getWrapped()->withScheme($scheme));
    }

    /**
     * @return static&UriInterface
     */
    public function withUserInfo(string $user, string|null $password = null): UriInterface
    {
        return $this->wrap($this->getWrapped()->withUserInfo($user, $password));
    }

    /**
     * @return static&UriInterface
     */
    public function withHost(string $host): UriInterface
    {
        return $this->wrap($this->getWrapped()->withHost($host));
    }

    /**
     * @return static&UriInterface
     */
    public function withPort(int|null $port): UriInterface
    {
        return $this->wrap($this->getWrapped()->withPort($port));
    }

    /**
     * @return static&UriInterface
     */
    public function withPath(string $path): UriInterface
    {
        return $this->wrap($this->getWrapped()->withPath($path));
    }

    /**
     * @return static&UriInterface
     */
    public function withQuery(string $query): UriInterface
    {
        return $this->wrap($this->getWrapped()->withQuery($query));
    }

    /**
     * @return static&UriInterface
     */
    public function withFragment(string $fragment): UriInterface
    {
        return $this->wrap($this->getWrapped()->withFragment($fragment));
    }

    public function __toString(): string
    {
        return (string)$this->getWrapped();
    }
}
