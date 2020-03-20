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

namespace Geeshoe\Atom\UnitTests\Generator;

use Geeshoe\Atom\Generator\ElementTrait;
use Geeshoe\Atom\Generator\FeedGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class FeedGeneratorTest extends TestCase
{
    /** @var \DOMDocument|MockObject */
    public $mockDocument;

    /** {@inheritdoc} */
    protected function setUp(): void
    {
        $this->mockDocument = $this->createMock(\DOMDocument::class);
    }

    public function usesElementTrait(): void
    {
        $traits = \class_uses(FeedGenerator::class);
        self::assertArrayHasKey(ElementTrait::class, $traits);
    }

    /** @test */
    public function createFeedElementUsesFeedTagWithRFCNamespace(): void
    {
        $tag = 'feed';
        $namespaceURI = 'http://www.w3.org/2005/Atom';

        $document = $this->createMock(\DOMDocument::class);
        $document
            ->expects($this->once())
            ->method('createElementNS')
            ->with($namespaceURI, $tag)
            ->willReturn($this->createMock(\DOMElement::class))
        ;

        $generator = new FeedGenerator($document);
        $generator->createFeedElement();
    }

    /** @test */
    public function getFeedCreatesFeedsWithRequiredElements(): void
    {
        $id = 'http://geeshoe.com/';
        $title = 'Unit Test';

        $date = new \DateTimeImmutable();
        $updated = $date->format(\DATE_ATOM);

        $feedElement = $this->getMockElement();
        $idElement = $this->getMockElement();
        $titleElement = $this->getMockElement();
        $updatedElement = $this->getMockElement();

        // createFeedElement()
        $this->mockDocument
            ->expects($this->once())
            ->method('createElementNS')
            ->willReturn($feedElement)
        ;

        // getXElement() calls
        $this->mockDocument
            ->expects($this->exactly(3))
            ->method('createElement')
            ->withConsecutive(['id', $id], ['title', $title], ['updated', $updated])
            ->willReturnOnConsecutiveCalls($idElement, $titleElement, $updatedElement)
        ;

        // append elements to feed DOMElement
        $feedElement->expects($this->exactly(3))
            ->method('appendChild')
            ->withConsecutive([$idElement], [$titleElement], [$updatedElement])
        ;

        $generator = new FeedGenerator($this->mockDocument);
        $generator->getFeed($id, $title, $updated);
    }

    /** @return \DOMElement&MockObject */
    protected function getMockElement()
    {
        return $this->createMock(\DOMElement::class);
    }
}
