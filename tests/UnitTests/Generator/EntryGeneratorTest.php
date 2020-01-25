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

use Geeshoe\Atom\Generator\ElementTrait;
use Geeshoe\Atom\Generator\EntryGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class EntryGeneratorTest
 *
 * @package Geeshoe\Atom\UnitTests\Generator
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class EntryGeneratorTest extends TestCase
{
    /** @return \DOMElement&MockObject */
    protected function getMockElement()
    {
        return $this->createMock(\DOMElement::class);
    }

    /** @test */
    public function usesElementTrait(): void
    {
        $traits = class_uses(EntryGenerator::class);
        self::assertArrayHasKey(ElementTrait::class, $traits);
    }

    /** @test */
    public function getElementCreatesElementWithRequiredElements(): void
    {
        $id = 'https://geeshoe/com/';
        $title = 'Unit Tests';

        $date = new \DateTimeImmutable();
        $updated = $date->format(\DATE_ATOM);

        $entryElement = $this->getMockElement();
        $idElement = $this->getMockElement();
        $titleElement = $this->getMockElement();
        $updatedElement = $this->getMockElement();

        $document = $this->createMock(\DOMDocument::class);
        $document
            ->expects($this->exactly(4))
            ->method('createElement')
            ->withConsecutive(
                ['entry'],
                ['id', $id],
                ['title', $title],
                ['updated', $updated]
            )
            ->willReturnOnConsecutiveCalls(
                $entryElement,
                $idElement,
                $titleElement,
                $updatedElement
            )
        ;

        $entryElement
            ->expects($this->exactly(3))
            ->method('appendChild')
            ->withConsecutive([$idElement], [$titleElement], [$updatedElement])
        ;

        $generator = new EntryGenerator($document);
        $generator->getEntry($id, $title, $updated);
    }
}
