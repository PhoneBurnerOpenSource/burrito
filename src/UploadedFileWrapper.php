<?php

declare(strict_types=1);

namespace PhoneBurner\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

trait UploadedFileWrapper
{
    private UploadedFileInterface|null $wrapped = null;

    private function setWrapped(UploadedFileInterface $file): static
    {
        $this->wrapped = $file;
        return $this;
    }

    private function getWrapped(): UploadedFileInterface
    {
        return $this->wrapped ?? throw new \UnexpectedValueException('must set wrapped uploaded file first');
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
