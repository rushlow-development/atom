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

namespace RushlowDevelopment\Atom\UnitTests\Contract;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Contract\GeneratorInterface;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class GeneratorInterfaceTest extends TestCase
{
    /**
     * @return array<array>
     */
    public function requiredMethodDataProvider(): array
    {
        return [
            ['initialize'],
            ['addEntry'],
            ['generate'],
        ];
    }

    /**
     * @dataProvider requiredMethodDataProvider
     */
    public function testRequiredMethodsExistInInterface(string $methodName): void
    {
        self::assertTrue(method_exists(GeneratorInterface::class, $methodName));
    }
}
