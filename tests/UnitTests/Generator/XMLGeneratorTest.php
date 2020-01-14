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

use Geeshoe\Atom\Generator\XMLGenerator;
use PHPUnit\Framework\TestCase;

/**
 * Class XMLGeneratorTest
 *
 * @package Geeshoe\Atom\UnitTests\Generator
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class XMLGeneratorTest extends TestCase
{
    public function testGetXMLReturnsValidXMLDocument(): void
    {
        $generator = new XMLGenerator();

        self::assertSame(
            '<?xml version="1.0" encoding="UTF-8"?>' . "\n",
            $generator->getXML()
        );
    }

    /**
     * @return array<array> {'method', 'elementTag', 'elementValue'}
     * @throws \Exception
     */
    public function getElementWithTextNodeDataProvider(): array
    {
        $timeStamp = new \DateTimeImmutable('now');

        return [
            'getIdElement()' => ['getIdElement', 'id', 'some id'],
            'getTitleElement()' => ['getTitleElement', 'title', 'test'],
            'getUpdatedElement()' => ['getUpdatedElement', 'updated', $timeStamp->format(\DATE_ATOM)]
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
        $mockElement = $this->createMock(\DOMElement::class);

        $mockDocument = $this->createMock(\DOMDocument::class);
        $mockDocument->expects($this->once())
            ->method('createElement')
            ->with($elementName, $elementValue)
            ->willReturn($mockElement)
        ;

        $generator = new XMLGenerator($mockDocument);
        $generator->$methodName($elementValue);
    }
}
