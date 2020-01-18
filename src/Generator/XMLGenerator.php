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

use Geeshoe\Atom\Contract\EntryRequiredInterface;
use Geeshoe\Atom\Contract\FeedRequiredInterface;
use Geeshoe\Atom\Contract\GeneratorInterface;

/**
 * Class XMLGenerator
 *
 * @package Geeshoe\Atom\Generator
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class XMLGenerator implements GeneratorInterface
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

        $feedElement->appendChild($this->getIdElement($feed->getId()));
        $feedElement->appendChild($this->getTitleElement($feed->getTitle()));

        $timestamp = $feed->getUpdated()->format(\DATE_ATOM);

        $feedElement->appendChild($this->getUpdatedElement($timestamp));
        $this->document->appendChild($feedElement);
    }

    /**
     * Add entry element to Atom XML Feed
     *
     * @param EntryRequiredInterface $entry
     */
    public function addEntry(EntryRequiredInterface $entry): void
    {
        $entryNode = $this->createEntryNode($entry);
        $nodeList = $this->document->getElementsByTagName('feed');

        //@TODO FIX - This is sloppy
        $feed = $nodeList->item(0);
        $feed->appendChild($entryNode);
    }

    public function createEntryNode(EntryRequiredInterface $entryRequired): \DOMNode
    {
        $node = $this->document->createElement('entry');

        $timeStamp = $entryRequired->getUpdated()->format(\DATE_ATOM);

        $node->appendChild($this->getIdElement($entryRequired->getId()));
        $node->appendChild($this->getTitleElement($entryRequired->getTitle()));
        $node->appendChild($this->getUpdatedElement($timeStamp));

        return $node;
    }

    /**
     * Get XML Document
     *
     * @return string
     */
    public function generate(): string
    {
        $this->document->formatOutput = $this->pretty;

        return $this->document->saveXML();
    }

    /**
     * @param string $idValue   Value of the id tag
     * @return \DOMElement
     */
    public function getIdElement(string $idValue): \DOMElement
    {
        return $this->createElementWithTextNode('id', $idValue);
    }

    /**
     * @param string $titleValue Text value of the element
     * @return \DOMElement
     */
    public function getTitleElement(string $titleValue): \DOMElement
    {
        return $this->createElementWithTextNode('title', $titleValue);
    }

    /**
     * @param string $atomTimeStamp \DateTime::ATOM formatted time stamp
     * @return \DOMElement
     */
    public function getUpdatedElement(string $atomTimeStamp): \DOMElement
    {
        return $this->createElementWithTextNode('updated', $atomTimeStamp);
    }

    protected function createElementWithTextNode(string $name, string $text): \DOMElement
    {
        return $this->document->createElement($name, $text);
    }
}
