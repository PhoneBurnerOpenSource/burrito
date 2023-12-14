<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

abstract class EvolvingWrapperTestCase extends WrapperTestCase
{
    abstract public static function provideWithMethods(): iterable;

    #[Test]
    #[DataProvider('provideWithMethods')]
    public function withMethodsAreProxied(
        string $method,
        array $args,
        array|null $expected = null,
    ): void {
        // allow expected args to differ from the args we pass the wrapper
        // but if they're not defined, they are the same as what is passed to
        // the wrapper
        if (null === $expected) {
            $expected = $args;
        }

        $return = self::createStub(static::wrapped());

        $this->mock()->$method(...$expected)->willReturn($return)->shouldBeCalled();
        $sut = new (static::fixture())($this->mock()->reveal());
        self::assertSame($sut, $sut->$method(...$args));
    }

    #[Test]
    #[DataProvider('provideWithMethods')]
    public function withMethodsUseFactoryWhenProvided(
        string $method,
        array $args,
        array|null $expected = null,
    ): void {
        // allow expected args to differ from the args we pass the wrapper
        // but if they're not defined, they are the same as what is passed to
        // the wrapper
        $expected ??= $args;

        $return = self::createStub(static::wrapped());

        $wrapped = self::createStub(static::fixture());

        $this->mock()->$method(...$expected)->willReturn($return)->shouldBeCalled();

        $sut = new (static::fixture())($this->mock()->reveal(), static function ($message) use ($return, $wrapped): Stub {
            TestCase::assertSame($return, $message);
            return $wrapped;
        });

        self::assertSame($wrapped, $sut->$method(...$args));
    }
}
