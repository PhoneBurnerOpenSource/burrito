<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * @phpstan-require-implements UploadedFileInterface
 */
trait UploadedFileWrapper
{
    private UploadedFileInterface|null $wrapped = null;

    private \Closure|null $factory = null;

    private function setWrapped(UploadedFileInterface $file): static
    {
        $this->wrapped = $file;
        return $this;
    }

    protected function setWrappedFactory(callable $factory): void
    {
        $this->factory = $factory instanceof \Closure ? $factory : $factory(...);
    }

    public function getWrapped(): UploadedFileInterface
    {
        return $this->wrapped ??=
            $this->factory instanceof \Closure
                ? ($this->factory)()
                : throw new \UnexpectedValueException('must set wrapped message first');
    }

    public function getStream(): StreamInterface
    {
        return $this->getWrapped()->getStream();
    }

    public function moveTo(string $targetPath): void
    {
        $this->getWrapped()->moveTo($targetPath);
    }

    public function getSize(): int|null
    {
        return $this->getWrapped()->getSize();
    }

    public function getError(): int
    {
        return $this->getWrapped()->getError();
    }

    public function getClientFilename(): string|null
    {
        return $this->getWrapped()->getClientFilename();
    }

    public function getClientMediaType(): string|null
    {
        return $this->getWrapped()->getClientMediaType();
    }
}
