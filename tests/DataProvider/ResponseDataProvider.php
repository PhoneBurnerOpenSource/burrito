<?php

declare(strict_types=1);

namespace PhoneBurner\Tests\Http\Message\DataProvider;

use Generator;

trait ResponseDataProvider
{
    use MessageDataProvider {
        provideGetterMethods as provideMessageGetterMethods;
        provideWithMethods as provideMessageWithMethods;
    }

    public static function provideGetterMethods(): Generator
    {
        yield from self::provideMessageGetterMethods();

        yield "getStatusCode()" => ['getStatusCode', [], 200];
        yield "getReasonPhrase() => ''" => ['getReasonPhrase', [], ''];
        yield "getReasonPhrase() => 'OK'" => ['getReasonPhrase', [], 'OK'];
    }

    public static function provideWithMethods(): Generator
    {
        yield from self::provideMessageWithMethods();

        yield "withStatus(200)" => ['withStatus', [200], [200, '']];
        yield "withStatus(200, '')" => ['withStatus', [200, '']];
        yield "withStatus(200, 'OK')" => ['withStatus', [200, 'OK']];
    }
}
