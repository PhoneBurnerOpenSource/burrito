<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\Fixture;

use PhoneBurner\Http\Message\UploadedFileWrapper;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFileWrapperFixture implements UploadedFileInterface
{
    use UploadedFileWrapper;

    public function __construct(UploadedFileInterface|null $wrapped = null, callable|null $factory = null)
    {
        if ($wrapped instanceof UploadedFileInterface) {
            $this->setWrapped($wrapped);
        }

        if ($factory !== null) {
            $this->setWrappedFactory($factory);
        }
    }
}
