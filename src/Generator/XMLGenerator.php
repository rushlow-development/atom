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

namespace Geeshoe\Atom\Generator;

use Geeshoe\Atom\Contract\FeedRequiredInterface;

/**
 * Class XMLGenerator
 *
 * @package Geeshoe\Atom\Generator
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class XMLGenerator
{
    protected \DOMDocument $document;

    protected bool $pretty;

    /**
     * XMLGenerator constructor.
     *
     * @param \DOMDocument|null $document
     * @param bool              $pretty     Return pretty XML Document
     */
    public function __construct(\DOMDocument $document = null, bool $pretty = false)
    {
        if ($document === null) {
            $document = new \DOMDocument('1.0', 'UTF-8');
        }

        $this->document = $document;
        $this->pretty = $pretty;
    }

    /**
     * Create Atom 1.0 XML Feed Element
     *
     * @param FeedRequiredInterface $feed
     */
    public function initialize(FeedRequiredInterface $feed): void
    {
        $feedElement = $this->document->createElementNS(
            'https://www.w3.org/2005/Atom',
            'feed'
        );

        $feedElement->appendChild($this->getTitleElement($feed->getTitle()));
    }

    /**
     * Get XML Document
     *
     * @return string
     */
    public function getXML(): string
    {
        $this->document->formatOutput = $this->pretty;

        return $this->document->saveXML();
    }

    /**
     * @param string $titleValue Text value of the element
     * @return \DOMElement
     */
    public function getTitleElement(string $titleValue): \DOMElement
    {
        return $this->createElementWithTextNode('title', $titleValue);
    }

    protected function createElementWithTextNode(string $name, string $text): \DOMElement
    {
        return $this->document->createElement($name, $text);
    }
}