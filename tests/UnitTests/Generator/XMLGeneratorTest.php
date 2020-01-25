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

namespace Geeshoe\Atom\UnitTests\Generator;

use Geeshoe\Atom\Contract\EntryInterface;
use Geeshoe\Atom\Contract\FeedInterface;
use Geeshoe\Atom\Contract\GeneratorInterface;
use Geeshoe\Atom\Generator\FeedGenerator;
use Geeshoe\Atom\Generator\XMLGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLGeneratorTest
 *
 * @package Geeshoe\Atom\UnitTests\Generator
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class XMLGeneratorTest extends TestCase
{
    public ?MockObject $mockDocument;
    public ?MockObject $mockElement;
    public ?MockObject $mockNode;
    public ?MockObject $mockFeed;
    public ?MockObject $mockEntry;
    public ?MockObject $mockDateTimeImmutable;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(\DOMDocument::class);
        $this->mockElement = $this->createMock(\DOMElement::class);
        $this->mockNode = $this->createMock(\DOMNode::class);
        $this->mockFeed = $this->createMock(FeedInterface::class);
        $this->mockEntry = $this->createMock(EntryInterface::class);
        $this->mockDateTimeImmutable = $this->createMock(\DateTimeImmutable::class);
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        $this->mockDocument = null;
        $this->mockElement = null;
        $this->mockNode = null;
        $this->mockFeed = null;
        $this->mockEntry = null;
        $this->mockDateTimeImmutable = null;
    }

    protected function setDateTimeExpectation(): void
    {
        $this->mockDateTimeImmutable
            ->expects($this->once())
            ->method('format')
            ->with(\DATE_ATOM)
            ->willReturn('time')
        ;
    }

    public function testXMLGeneratorImplementsGeneratorInterface(): void
    {
        $interfaces = class_implements(XMLGenerator::class);

        self::assertArrayHasKey(GeneratorInterface::class, $interfaces);
    }

    public function testGetXMLReturnsValidXMLDocument(): void
    {
        $generator = new XMLGenerator();

        self::assertSame(
            '<?xml version="1.0" encoding="UTF-8"?>' . "\n",
            $generator->generate()
        );
    }

    public function testInitializeCreatesAtomFeedElement(): void
    {
        $this->setDateTimeExpectation();

        $this->mockFeed
            ->expects($this->once())
            ->method('getId')
            ->willReturn('id')
        ;

        $this->mockFeed
            ->expects($this->once())
            ->method('getTitle')
            ->willReturn('title')
        ;

        $this->mockFeed
            ->expects($this->once())
            ->method('getUpdated')
            ->willReturn($this->mockDateTimeImmutable)
        ;

        $feedGenerator = $this->createMock(FeedGenerator::class);
        $feedGenerator
            ->expects($this->once())
            ->method('getFeed')
            ->with('id', 'title', 'time')
        ;

        $this->mockDocument
            ->expects($this->once())
            ->method('appendChild')
            ->with(self::isInstanceOf(\DOMElement::class))
        ;

        $generator = new XMLGenerator($this->mockDocument, $feedGenerator);

        $generator->initialize($this->mockFeed);
    }

    protected function setExpectationsForCreateEntryNode(): void
    {
        $this->setDateTimeExpectation();

        $this->mockEntry
            ->expects($this->once())
            ->method('getUpdated')
            ->willReturn($this->mockDateTimeImmutable)
        ;

        $node = $this->mockElement;
        $node
            ->expects($this->exactly(3))
            ->method('appendChild')
        ;

        $this->mockDocument
            ->expects($this->exactly(4))
            ->method('createElement')
            ->withConsecutive(['entry'], ['id', ''], ['title', ''], ['updated', 'time'])
            ->willReturnOnConsecutiveCalls(
                $node,
                $this->mockElement,
                $this->mockElement,
                $this->mockElement
            )
        ;
    }

    public function testCreateEntryNodeCreatesNodeAndAppendsRequiredElementsToNode(): void
    {
        $this->setExpectationsForCreateEntryNode();

        $generator = new XMLGenerator($this->mockDocument);
        $generator->createEntryElement($this->mockEntry);
    }

    public function testAddEntryAppendsFeedElementWithNewEntry(): void
    {
        $this->setExpectationsForCreateEntryNode();

        $mockNodeList = $this->createMock(\DOMNodeList::class);
        $mockNodeList
            ->expects($this->once())
            ->method('item')
            ->with(0)
            ->willReturn($this->mockNode)
        ;

        $this->mockNode
            ->expects($this->once())
            ->method('appendChild')
            ->with(self::isInstanceOf(\DOMNode::class))
        ;

        $this->mockDocument
            ->expects($this->once())
            ->method('getElementsByTagName')
            ->with('feed')
            ->willReturn($mockNodeList)
        ;

        $generator = new XMLGenerator($this->mockDocument);
        $generator->addEntry($this->mockEntry);
    }
}
