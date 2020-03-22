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

namespace Geeshoe\Atom\UnitTests\Model;

use Geeshoe\Atom\Collection\PersonCollection;
use Geeshoe\Atom\Exception\ModelException;
use Geeshoe\Atom\Model\Feed;
use Geeshoe\Atom\UnitTests\AbstractModelTest;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class FeedTest extends AbstractModelTest
{
    public array $expected = [];

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->classUnderTest = Feed::class;
        $this->getExpected();
    }

    public function requiredPropertyPerRFCDataProvider(): \Generator
    {
        yield 'Author' => ['author'];
        yield 'Id' => ['id'];
        yield 'Title' => ['title'];
        yield 'Updated' => ['updated'];
    }

    public function optionalPropertyPerRFCDataProvider(): \Generator
    {
        yield 'Category' => ['category'];
        yield 'Contributor' => ['contributor'];
        yield 'Generator' => ['generator'];
        yield 'Icon' => ['icon'];
        yield 'Logo' => ['logo'];
        yield 'Link' => ['link'];
        yield 'Rights' => ['rights'];
        yield 'Subtitle' => ['subtitle'];
    }

    /**
     * @return array<array>
     */
    public function getterDateProvider(): array
    {
        $this->getExpected();

        return [
            ['getId', $this->expected['id']],
            ['getTitle', $this->expected['title']],
            ['getUpdated', $this->expected['updated']],
        ];
    }

    /**
     * @dataProvider getterDateProvider
     *
     * @param mixed $expected
     */
    public function testGetters(string $name, $expected): void
    {
        $feed = new Feed($this->expected['id'], $this->expected['title'], $this->expected['updated']);

        self::assertEquals($expected, $feed->$name());
    }

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
     */
    public function testGetIdThrowsExceptionWithEmptyValue(
        string $methodName,
        string $expectedMsg,
        array $constructorParams
    ): void {
        $feed = new Feed(...$constructorParams);

        $this->expectException(ModelException::class);
        $this->expectExceptionMessage("$expectedMsg value is empty or uninitialized");

        $feed->$methodName();
    }

    public function optionalElementGetterSetters(): array
    {
        return [
            ['getAuthor', 'setAuthor', new PersonCollection()],
        ];
    }

    /**
     * @dataProvider optionalElementGetterSetters
     *
     * @param mixed $expected
     */
    public function testOptionalFeedGetterSetters(string $getter, string $setter, $expected): void
    {
        $params = [];
        foreach ($this->expected as $value) {
            $params[] = $value;
        }

        $feed = new Feed(...$params);

        $feed->$setter($expected);

        self::assertSame($expected, $feed->$getter());
    }

    /** @test */
    public function constructCreatesAuthorElementCollection(): void
    {
        $feed = new Feed('', '', $this->expected['updated']);
        self::assertInstanceOf(PersonCollection::class, $feed->getAuthor());
    }

    protected function getExpected(): void
    {
        $time = $this->createMock(\DateTime::class);

        $this->expected = [
            'id' => 'test_id',
            'title' => 'test_title',
            'updated' => $time,
        ];
    }
}
