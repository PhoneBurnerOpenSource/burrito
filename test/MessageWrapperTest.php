<?php

namespace PhoneBurnerTest\Http\Message;

use PhoneBurnerTest\Http\Message\DataProvider\MessageDataProvider;
use PhoneBurnerTest\Http\Message\Fixture\MessageWrapperFixture;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface;

class MessageWrapperTest extends TestCase
{
    use MessageDataProvider;
    use CommonWrapperTests;

    private const WRAPPED_CLASS = MessageInterface::class;
    private const FIXTURE_CLASS = MessageWrapperFixture::class;
}