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

namespace RushlowDevelopment\Atom\UnitTests\Model;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Exception\ModelException;
use RushlowDevelopment\Atom\Model\Atom;
use RushlowDevelopment\Atom\Model\Entry;
use RushlowDevelopment\Atom\Model\Feed;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class AtomTest extends TestCase
{
    /**
     * @return array<array>
     */
    public function requiredPropertyDataProvider(): array
    {
        return [
            'FeedElement Property not found' => ['feedElement'],
            'EntryElements Property not found' => ['entryElements'],
        ];
    }

    /**
     * @dataProvider requiredPropertyDataProvider
     */
    public function testAtomHasRequiredProperties(string $propertyName): void
    {
        self::assertClassHasAttribute($propertyName, Atom::class);
    }

    public function testGetFeedElementThrowsModelExceptionIfFeedElementNotSet(): void
    {
        $this->expectException(ModelException::class);

        $atom = new Atom();
        $atom->getFeedElement();
    }

    public function testFeedElementGetterSetter(): void
    {
        $mockFeed = $this->createMock(Feed::class);

        $atom = new Atom();
        $atom->setFeedElement($mockFeed);

        $this->assertSame($mockFeed, $atom->getFeedElement());
    }

    public function testEntryElementGetterAlwaysReturnsArray(): void
    {
        $atom = new Atom();

        $this->assertSame([], $atom->getEntryElements());
    }

    public function testEntryElementsGetterSetter(): void
    {
        $mockEntry = $this->createMock(Entry::class);

        $atom = new Atom();
        $atom->addEntryElement($mockEntry);

        $expected[] = $mockEntry;

        $this->assertSame($expected, $atom->getEntryElements());
    }
}
