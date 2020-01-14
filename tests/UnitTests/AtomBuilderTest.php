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

namespace Geeshoe\Atom\UnitTests;

use Geeshoe\Atom\AtomBuilder;
use Geeshoe\Atom\Model\Atom;
use Geeshoe\Atom\Model\Entry;
use Geeshoe\Atom\Model\Feed;
use PHPUnit\Framework\TestCase;

/**
 * Class AtomBuilderTest
 *
 * @package Geeshoe\Atom\UnitTests
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class AtomBuilderTest extends TestCase
{
    public function testConstructorCreatesAtomInstanceIfOneNotProvided(): void
    {
        $builder = new AtomBuilder();

        $this->assertInstanceOf(Atom::class, $builder->getAtom());
    }

    public function testConstructorSetAtomInstanceProvidedAsParam(): void
    {
        $mockAtom = $this->createMock(Atom::class);

        $builder = new AtomBuilder($mockAtom);

        $this->assertSame($mockAtom, $builder->getAtom());
    }

    public function testCreateFeedCallsAtomSetFeedElementWithProvidedElementParams(): void
    {
        $mockAtom = $this->createMock(Atom::class);
        $mockAtom->expects($this->once())
            ->method('setFeedElement')
            ->with(self::isInstanceOf(Feed::class))
        ;

        $mockTime = $this->createMock(\DateTime::class);

        $builder = new AtomBuilder($mockAtom);
        $builder->createFeed('testId', 'testTitle', $mockTime);
    }

    public function testAddEntryCallsAtomAddEntryElementWithEntryModel(): void
    {
        $mockAtom = $this->createMock(Atom::class);
        $mockAtom->expects($this->once())
            ->method('addEntryElement')
            ->with(self::isInstanceOf(Entry::class))
        ;

        $mockTime = $this->createMock(\DateTime::class);

        $builder = new AtomBuilder($mockAtom);
        $builder->addEntry('testId', 'testTitle', $mockTime);
    }
}
