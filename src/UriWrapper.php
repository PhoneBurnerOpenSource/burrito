<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\UriInterface;

trait UriWrapper
{
    private UriInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    /**
     * @param callable(UriInterface): static $factory
     */
    protected function setFactory(callable $factory): static
    {
        $this->factory = $factory(...);
        return $this;
    }

    /**
     * @return static&UriInterface
     */
    private function viaFactory(UriInterface $uri): static
    {
        return $this->factory ? ($this->factory)($uri) : $this->setWrapped($uri);
    }

    protected function setWrapped(UriInterface $uri): static
    {
        $this->wrapped = $uri;
        return $this;
    }

    private function getWrapped(): UriInterface
    {
        return $this->wrapped ?: throw new \UnexpectedValueException('must set wrapped uri first');
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
        return $this->viaFactory($this->getWrapped()->withScheme($scheme));
    }

    /**
     * @return static&UriInterface
     */
    public function withUserInfo(string $user, string|null $password = null): UriInterface
    {
        return $this->viaFactory($this->getWrapped()->withUserInfo($user, $password));
    }

    /**
     * @return static&UriInterface
     */
    public function withHost(string $host): UriInterface
    {
        return $this->viaFactory($this->getWrapped()->withHost($host));
    }

    /**
     * @return static&UriInterface
     */
    public function withPort(int|null $port): UriInterface
    {
        return $this->viaFactory($this->getWrapped()->withPort($port));
    }

    /**
     * @return static&UriInterface
     */
    public function withPath(string $path): UriInterface
    {
        return $this->viaFactory($this->getWrapped()->withPath($path));
    }

    /**
     * @return static&UriInterface
     */
    public function withQuery(string $query): UriInterface
    {
        return $this->viaFactory($this->getWrapped()->withQuery($query));
    }

    /**
     * @return static&UriInterface
     */
    public function withFragment(string $fragment): UriInterface
    {
        return $this->viaFactory($this->getWrapped()->withFragment($fragment));
    }

    public function __toString(): string
    {
        return (string)$this->getWrapped();
    }
}
