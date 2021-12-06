<?php

/*
 * Copyright 2020 Jesse Rushlow - Rushlow Development.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace RushlowDevelopment\Atom\UnitTests\Exception;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Contract\AtomExceptionInterface;
use RushlowDevelopment\Atom\Exception\FactoryException;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class FactoryExceptionTest extends TestCase
{
    public function testFactoryExceptionImplementsAtomExceptionInterface(): void
    {
        $implements = class_implements(FactoryException::class);

        $this->assertArrayHasKey(AtomExceptionInterface::class, $implements);
    }

    /**
     * @return array<array> [[FactoryException::CONST, 'message']]
     */
    public function staticExceptionMsgDataProvider(): array
    {
        return [
            ['REQUIRED_MSG', 'A required attribute is empty.'],
        ];
    }

    /**
     * @dataProvider staticExceptionMsgDataProvider
     */
    public function testStaticExceptionMessagesAreDefined(string $signature, string $message): void
    {
        $class = '\RushlowDevelopment\Atom\Exception\FactoryException::';
        self::assertSame(\constant($class.$signature), $message);
    }

    public function testRequiredExceptionProvidesRequiredMsgConst(): void
    {
        $result = FactoryException::requiredException();

        $this->assertSame(FactoryException::REQUIRED_MSG, $result->getMessage());
    }

    public function testRequiredExceptionPassesThrowableToException(): void
    {
        $expected = new \Exception('test');

        $this->assertSame($expected, FactoryException::requiredException($expected)->getPrevious());
    }
}
