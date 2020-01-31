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

namespace Geeshoe\Atom\UnitTests\Model;

use Geeshoe\Atom\Collection\ElementCollection;
use Geeshoe\Atom\Contract\CollectionInterface;
use Geeshoe\Atom\Exception\ModelException;
use Geeshoe\Atom\Model\Author;
use Geeshoe\Atom\Model\Entry;
use PHPUnit\Framework\TestCase;

/**
 * Class EntryTest
 *
 * @package Geeshoe\Atom\UnitTests\Model
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class EntryTest extends TestCase
{
    public array $expected = [];

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->getExpected();
    }

    protected function getExpected(): void
    {
        $time = $this->createMock(\DateTime::class);

        $this->expected = [
            'id' => 'test_id',
            'title' => 'test_title',
            'updated' => $time
        ];
    }

    /**
     * @return array<array>
     */
    public function getterDataProvider(): array
    {
        $this->getExpected();

        return [
            ['getId', $this->expected['id']],
            ['getTitle', $this->expected['title']],
            ['getUpdated', $this->expected['updated']]
        ];
    }

    /**
     * @dataProvider getterDataProvider
     * @param string $methodName
     * @param mixed  $expected
     */
    public function testGetters(string $methodName, $expected): void
    {
        $entry = new Entry($this->expected['id'], $this->expected['title'], $this->expected['updated']);

        self::assertEquals($expected, $entry->$methodName());
    }

    /**
     * @return array<array>
     */
    public function exceptionDataProvider(): array
    {
        $this->getExpected();

        return [
            ['getId', 'Id', ['', $this->expected['title'], $this->expected['updated']]],
            ['getTitle', 'Title', [$this->expected['id'], '', $this->expected['updated']]],
        ];
    }

    /**
     * @dataProvider exceptionDataProvider
     * @param string $methodName
     * @param string $expectedMsg
     * @param array  $constructorParams
     */
    public function testGetterExceptions(
        string $methodName,
        string $expectedMsg,
        array $constructorParams
    ): void {
        $entry = new Entry(...$constructorParams);

        $this->expectException(ModelException::class);
        $this->expectExceptionMessage("$expectedMsg value is empty or uninitialized");

        $entry->$methodName();
    }

    public function optionalElementGetterSetters(): array
    {
        return [
            ['getAuthors', 'setAuthors', $this->createMock(CollectionInterface::class)]
        ];
    }

    /**
     * @dataProvider optionalElementGetterSetters
     * @param mixed $expected
     */
    public function testOptionalEntryGetterSetters(string $getter, string $setter, $expected): void
    {
        $params = [];
        foreach ($this->expected as $value) {
            $params[] = $value;
        }

        $entry = new Entry(...$params);

        $entry->$setter($expected);

        self::assertSame($expected, $entry->$getter());
    }

    public function testAddAuthorAddsAuthorToExistingCollection(): void
    {
        $mockAuthor = $this->createMock(Author::class);

        $feed = new Entry('', '', $this->expected['updated']);

        $collection = $this->createMock(ElementCollection::class);
        $collection->expects($this->once())
            ->method('add')
            ->with($mockAuthor);

        $feed->setAuthors($collection);

        $feed->addAuthor($mockAuthor);
    }

    public function testConstructorCreatesCollectionForAuthor(): void
    {
        $entry = new Entry('', '', $this->expected['updated']);

        self::assertInstanceOf(ElementCollection::class, $entry->getAuthors());
    }
}
