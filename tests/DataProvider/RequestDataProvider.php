<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\DataProvider;

use Generator;
use Psr\Http\Message\UriInterface;

trait RequestDataProvider
{
    use MessageDataProvider {
        provideGetterMethods as provideMessageGetterMethods;
        provideWithMethods as provideMessageWithMethods;
    }

    public static function provideGetterMethods(): Generator
    {
        yield from self::provideMessageGetterMethods();

        yield "getRequestTarget()" => ['getRequestTarget', [], '*'];

        yield "getMethod() => POST" => ['getMethod', [], 'POST'];
        yield "getMethod() => GET" => ['getMethod', [], 'GET'];
        yield "getMethod() => PUT" => ['getMethod', [], 'PUT'];
        yield "getMethod() => DELETE" => ['getMethod', [], 'DELETE'];

        $uri = self::createStub(UriInterface::class);

        yield "getUri()" => ['getUri', [], $uri];
    }

    public static function provideWithMethods(): Generator
    {
        yield from self::provideMessageWithMethods();

        yield "withRequestTarget(*)" => ['withRequestTarget', ['*']];

        yield "withMethod('POST')" => ['withMethod', ['POST']];
        yield "withMethod('GET')" => ['withMethod', ['GET']];
        yield "withMethod('PUT')" => ['withMethod', ['PUT']];
        yield "withMethod('DELETE')" => ['withMethod', ['DELETE']];

        $uri = self::createStub(UriInterface::class);

        yield "withUri(\$uri)" => ['withUri', [$uri], [$uri, false]];
        yield "withUri(\$uri, false)" => ['withUri', [$uri, false]];
        yield "withUri(\$uri, true)" => ['withUri', [$uri, true]];
    }
}
