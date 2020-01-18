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

use Geeshoe\Atom\Contract\EntryRequiredInterface;
use Geeshoe\Atom\Contract\FeedRequiredInterface;
use Geeshoe\Atom\Contract\GeneratorInterface;
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
        $this->mockFeed = $this->createMock(FeedRequiredInterface::class);
        $this->mockEntry = $this->createMock(EntryRequiredInterface::class);
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

    /**
     * @return array<array> {'method', 'elementTag', 'elementValue'}
     * @throws \Exception
     */
    public function getElementWithTextNodeDataProvider(): array
    {
        return [
            'getIdElement()' => ['getIdElement', 'id', 'some id'],
            'getTitleElement()' => ['getTitleElement', 'title', 'test'],
            'getUpdatedElement()' => ['getUpdatedElement', 'updated', 'time']
        ];
    }

    /**
     * @dataProvider getElementWithTextNodeDataProvider
     * @param string $methodName
     * @param string $elementName
     * @param string $elementValue
     */
    public function testGetterElementWithTextNodeCreatesElementWithSuppliedParams(
        string $methodName,
        string $elementName,
        string $elementValue
    ): void {
        $this->mockDocument->expects($this->once())
            ->method('createElement')
            ->with($elementName, $elementValue)
            ->willReturn($this->mockElement)
        ;

        $generator = new XMLGenerator($this->mockDocument);
        $generator->$methodName($elementValue);
    }

    public function testInitializeCreatesAtomFeedElement(): void
    {
        $this->mockDocument->expects($this->once())
            ->method('createElementNS')
            ->with('https://www.w3.org/2005/Atom', 'feed')
            ->willReturn($this->mockNode);

        $this->mockNode->expects($this->exactly(3))
            ->method('appendChild')
            ->with(self::isInstanceOf(\DOMElement::class))
        ;

        $this->setMockFeedExpectations();

        $this->mockDocument->expects($this->exactly(3))
            ->method('createElement')
            ->willReturn($this->mockElement);

        $generator = new XMLGenerator($this->mockDocument);

        $generator->initialize($this->mockFeed);
    }

    protected function setMockFeedExpectations(): void
    {
        $feedMethods = ['getId', 'getTitle'];

        foreach ($feedMethods as $method) {
            $this->mockFeed->expects($this->once())
                ->method($method);
        }

        $this->mockDateTimeImmutable->expects($this->once())
            ->method('format')
            ->with(\DATE_ATOM)
            ->willReturn('time');

        $this->mockFeed->expects($this->once())
            ->method('getUpdated')
            ->willReturn($this->mockDateTimeImmutable);
    }

    public function testCreateEntryNodeCreatesNodeAndAppendsRequiredElementsToNode(): void
    {
        $this->setExpectationsForCreateEntryNode();

        $generator = new XMLGenerator($this->mockDocument);
        $generator->createEntryNode($this->mockEntry);
    }

    protected function setExpectationsForCreateEntryNode(): void
    {
        $this->mockDateTimeImmutable->expects($this->once())
            ->method('format')
            ->with(\DATE_ATOM)
            ->willReturn('');

        $this->mockEntry->expects($this->once())
            ->method('getUpdated')
            ->willReturn($this->mockDateTimeImmutable);

        $node = $this->mockElement;
        $node->expects($this->exactly(3))
            ->method('appendChild');


        $this->mockDocument->expects($this->exactly(4))
            ->method('createElement')
            ->withConsecutive(['entry'], ['id', ''], ['title', ''], ['updated', ''])
            ->willReturnOnConsecutiveCalls(
                $node,
                $this->mockElement,
                $this->mockElement,
                $this->mockElement
            );
    }

    public function testAddEntryAppendsFeedElementWithNewEntry(): void
    {
        $this->setExpectationsForCreateEntryNode();

        $mockNodeList = $this->createMock(\DOMNodeList::class);
        $mockNodeList->expects($this->once())
            ->method('item')
            ->with(0)
            ->willReturn($this->mockNode);

        $this->mockNode->expects($this->once())
            ->method('appendChild')
            ->with(self::isInstanceOf(\DOMNode::class));

        $this->mockDocument->expects($this->once())
            ->method('getElementsByTagName')
            ->with('feed')
            ->willReturn($mockNodeList);

        $generator = new XMLGenerator($this->mockDocument);
        $generator->addEntry($this->mockEntry);
    }
}
