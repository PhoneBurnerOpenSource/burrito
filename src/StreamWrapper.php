<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\StreamInterface;

/**
 * @phpstan-require-implements StreamInterface
 */
trait StreamWrapper
{
    private StreamInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    protected function setWrapped(StreamInterface $stream): static
    {
        $this->wrapped = $stream;
        return $this;
    }

    protected function setWrappedFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    public function getWrapped(): StreamInterface
    {
        return $this->wrapped ??= $this->factory instanceof \Closure
            ? ($this->factory)()
            : throw new \UnexpectedValueException('must set wrapped stream first');
    }

    public function __toString(): string
    {
        return (string)$this->getWrapped();
    }

    public function close(): void
    {
        $this->getWrapped()->close();
    }

    public function detach(): mixed
    {
        return $this->getWrapped()->detach();
    }

    public function getSize(): int|null
    {
        return $this->getWrapped()->getSize();
    }

    public function tell(): int
    {
        return $this->getWrapped()->tell();
    }

    public function eof(): bool
    {
        return $this->getWrapped()->eof();
    }

    public function isSeekable(): bool
    {
        return $this->getWrapped()->isSeekable();
    }

    public function seek($offset, $whence = \SEEK_SET): void
    {
        $this->getWrapped()->seek($offset, $whence);
    }

    public function rewind(): void
    {
        $this->getWrapped()->rewind();
    }

    public function isWritable(): bool
    {
        return $this->getWrapped()->isWritable();
    }

    public function write(string $string): int
    {
        return $this->getWrapped()->write($string);
    }

    public function isReadable(): bool
    {
        return $this->getWrapped()->isReadable();
    }

    public function read(int $length): string
    {
        return $this->getWrapped()->read($length);
    }

    public function getContents(): string
    {
        return $this->getWrapped()->getContents();
    }

    public function getMetadata($key = null): mixed
    {
        return $this->getWrapped()->getMetadata($key);
    }
}
