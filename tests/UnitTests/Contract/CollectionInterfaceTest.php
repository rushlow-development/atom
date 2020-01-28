<?php

/**
 * Copyright 2020 Jesse Rushlow - Geeshoe Development
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

declare(strict_types=1);

namespace Geeshoe\Atom\UnitTests\Contract;

use Geeshoe\Atom\Contract\CollectionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class CollectionInterfaceTest
 *
 * @package Geeshoe\Atom\UnitTests\Contract
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class CollectionInterfaceTest extends TestCase
{
    public function interfaceDateProvider(): array
    {
        return [
            [\ArrayAccess::class],
            [\Countable::class],
            [\IteratorAggregate::class]
        ];
    }

    /**
     * @dataProvider interfaceDateProvider
     */
    public function testCollectionInterfaceExtendsInterfaces(string $interfaceSignature): void
    {
        $collection = $this->createMock(CollectionInterface::class);

        self::assertInstanceOf($interfaceSignature, $collection);
    }

    /** @return \Generator<array<string>> */
    public function methodDataProvider(): \Generator
    {
        yield ['add'];
        yield ['isEmpty'];
    }

    /**
     * @dataProvider methodDataProvider
     */
    public function testHasMethods(string $methodName): void
    {
        self::assertTrue(method_exists(CollectionInterface::class, $methodName));
    }
}
