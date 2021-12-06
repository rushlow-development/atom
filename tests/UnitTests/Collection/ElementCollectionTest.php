<?php

/**
 * Copyright 2020 Jesse Rushlow - Geeshoe Development.
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

namespace RushlowDevelopment\Atom\UnitTests\Collection;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Collection\ElementCollection;
use RushlowDevelopment\Atom\Contract\CollectionInterface;
use RushlowDevelopment\Atom\Contract\ElementInterface;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class ElementCollectionTest extends TestCase
{
    protected ?MockObject $mockElementInterface;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->mockElementInterface = $this->createMock(ElementInterface::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->mockElementInterface = null;
    }

    public function testElementCollectionImplementsCollectionInterface(): void
    {
        self::assertInstanceOf(CollectionInterface::class, new ElementCollection());
    }

    public function testElementCollectionHasElementProperty(): void
    {
        self::assertClassHasAttribute('elements', ElementCollection::class);
    }

    public function interfaceMethodDataProvider(): \Generator
    {
        yield ['offsetExists'];
        yield ['offsetGet'];
        yield ['offsetSet'];
        yield ['offsetUnset'];
        yield ['count'];
        yield ['getIterator'];
    }

    /**
     * @dataProvider interfaceMethodDataProvider
     */
    public function testElementCollectionImplementsInterfaceMethods(string $methodName): void
    {
        self::assertTrue(method_exists(ElementCollection::class, $methodName));
    }

    public function testAddMethodAddsElementInterfaceToCollection(): void
    {
        $collection = new ElementCollection();
        $collection->add($this->mockElementInterface);

        self::assertSame($this->mockElementInterface, $collection[0]);
    }

    public function testCountReturnsCountOfElementsProperty(): void
    {
        $collection = new ElementCollection();
        $collection->add($this->mockElementInterface);
        $collection->add($this->mockElementInterface);

        self::assertSame(2, $collection->count());
    }

    public function testGetIteratorProvidesArrayIteratorForElementProperty(): void
    {
        $collection = new ElementCollection();
        $collection->add($this->mockElementInterface);

        $result = $collection->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $result);
        self::assertCount(1, $result);
    }

    public function testOffsetExistsReturnsBoolIfElementsPropertyKeyExists(): void
    {
        $collection = new ElementCollection();

        self::assertFalse($collection->offsetExists(0));
        $collection->add($this->mockElementInterface);
        self::assertTrue($collection->offsetExists(0));
    }

    public function testOffsetGetReturnsElementFromElementsPropertyAtGivenKey(): void
    {
        $collection = new ElementCollection();
        $collection->add($this->mockElementInterface);

        self::assertSame($this->mockElementInterface, $collection->offsetGet(0));
    }

    public function testOffsetSetAddsElementToElementsPropertyWithNullKey(): void
    {
        $collection = new ElementCollection();
        $collection->offsetSet(null, $this->mockElementInterface);

        self::assertArrayHasKey(0, $collection);
    }

    public function testOffsetSetAddsElementToElementsPropertyWithKey(): void
    {
        $collection = new ElementCollection();
        $collection->offsetSet('test', $this->mockElementInterface);

        self::assertArrayHasKey('test', $collection);
    }

    public function testOffsetUnsetRemovesElementFromElementsPropertyWithProvidedKey(): void
    {
        $collection = new ElementCollection();
        $collection[5] = $this->mockElementInterface;

        self::assertCount(1, $collection);

        $collection->offsetUnset(5);
        self::assertCount(0, $collection);
    }

    public function testIsEmptyReturnsExpectedResult(): void
    {
        $collection = new ElementCollection();
        self::assertTrue($collection->isEmpty());

        $collection[] = $this->mockElementInterface;
        self::assertFalse($collection->isEmpty());
    }
}
