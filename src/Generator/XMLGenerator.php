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

namespace RushlowDevelopment\Atom\Generator;

use RushlowDevelopment\Atom\Contract\EntryInterface;
use RushlowDevelopment\Atom\Contract\FeedInterface;
use RushlowDevelopment\Atom\Contract\GeneratorInterface;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class XMLGenerator implements GeneratorInterface
{
    protected \DOMDocument $document;
    protected FeedGenerator $feed;
    protected EntryGenerator $entry;

    protected bool $pretty;

    /**
     * XMLGenerator constructor.
     *
     * @param bool $pretty Return pretty XML Document
     */
    public function __construct(
        \DOMDocument $document = null,
        FeedGenerator $feedGenerator = null,
        EntryGenerator $entryGenerator = null,
        bool $pretty = false
    ) {
        if (null === $document) {
            $document = new \DOMDocument('1.0', 'UTF-8');
        }

        $this->feed = $feedGenerator ?? new FeedGenerator($document);
        $this->entry = $entryGenerator ?? new EntryGenerator($document);
        $this->document = $document;
        $this->pretty = $pretty;
    }

    /**
     * Create Atom 1.0 XML Feed Element.
     */
    public function initialize(FeedInterface $feed): void
    {
        $updated = $feed->getUpdated()->format(\DATE_ATOM);

        $feedElement = $this->feed->getFeed(
            $feed->getId(),
            $feed->getTitle(),
            $updated
        );

        $this->document->appendChild($feedElement);
    }

    /**
     * Add entry element to Atom XML Feed.
     */
    public function addEntry(EntryInterface $entry): void
    {
        $entryNode = $this->createEntryElement($entry);

        $feed = $this->document->getElementById('feed');
        $feed->appendChild($entryNode);
    }

    public function createEntryElement(EntryInterface $entry): \DOMElement
    {
        $updated = $entry->getUpdated()->format(\DATE_ATOM);

        return $this->entry->getEntry(
            $entry->getId(),
            $entry->getTitle(),
            $updated
        );
    }

    /**
     * Get XML Document.
     */
    public function generate(): string
    {
        $this->document->formatOutput = $this->pretty;

        return $this->document->saveXML();
    }
}
