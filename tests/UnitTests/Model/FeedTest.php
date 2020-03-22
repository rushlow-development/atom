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

use Geeshoe\Atom\Collection\CategoryCollection;
use Geeshoe\Atom\Collection\LinkCollection;
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
    private array $expected = [];

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
        $this->getExpected();

        yield 'Id' => ['id', $this->expected['id']];
        yield 'Title' => ['title', $this->expected['title']];
        yield 'Updated' => ['updated', $this->expected['updated']];
    }

    public function optionalPropertyPerRFCDataProvider(): \Generator
    {
        yield 'Author' => ['author', new PersonCollection()];
        yield 'Category' => ['category', new CategoryCollection()];
        yield 'Contributor' => ['contributor', new PersonCollection()];
        yield 'Generator' => ['generator', 'generated'];
        yield 'Icon' => ['icon', 'link-to-icon'];
        yield 'Logo' => ['logo', 'link-to-logo'];
        yield 'Link' => ['link', new LinkCollection()];
        yield 'Rights' => ['rights', 'rights'];
        yield 'Subtitle' => ['subtitle', 'this is the subtitle'];
    }

    /**
     * @dataProvider requiredPropertyPerRFCDataProvider
     *
     * @param mixed $expected
     */
    public function testRequiredGetters(string $name, $expected): void
    {
        $feed = new Feed($this->expected['id'], $this->expected['title'], $this->expected['updated']);

        $getter = 'get'.\ucfirst($name);
        self::assertEquals($expected, $feed->$getter());
    }

    /**
     * @dataProvider optionalPropertyPerRFCDataProvider
     *
     * @param mixed $expected
     */
    public function testOptionalGetterSetters(string $property, $expected): void
    {
        $params = [];
        foreach ($this->expected as $value) {
            $params[] = $value;
        }

        $feed = new Feed(...$params);

        $setter = 'set'.\ucfirst($property);
        $getter = 'get'.\ucfirst($property);

        $feed->$setter($expected);

        self::assertSame($expected, $feed->$getter());
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
