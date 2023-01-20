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

namespace RushlowDevelopment\Atom\Generator;

use RushlowDevelopment\Atom\Model\Entry;
use RushlowDevelopment\Atom\Model\Feed;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class AtomXmlGenerator
{
    private \DOMDocument $document;

    public function __construct(
    ) {
        $this->document = new \DOMDocument('1.0', 'UTF-8');
    }

    public function getDocument(): \DOMDocument
    {
        return $this->document;
    }

    public function buildFeedElement(Feed $feedModel): void
    {
        $feedElement = $this->document->createElementNS(
            'http://www.w3.org/2005/Atom',
            'feed'
        );

        if (null === $feedElement) {
            throw new \RuntimeException('"feed" element does not exist.');
        }

        try {
            $feedElement->appendChild(new \DOMElement('id', $feedModel->getId()));
            $feedElement->appendChild(new \DOMElement('title', $feedModel->getTitle()));
            $feedElement->appendChild(new \DOMElement('updated', $feedModel->getUpdated()->format(\DATE_ATOM)));

            if (null !== $link = $feedModel->getLink()) {
                $linkElement = $this->document->createElement('link');
                $linkElement->setAttribute('href', $link->getHref());
                $linkElement->setAttribute('rel', $link->getRel());
                $feedElement->appendChild($linkElement);
            }

            if (null !== $subtitle = $feedModel->getSubtitle()) {
                $feedElement->appendChild(new \DOMElement('subtitle', $subtitle));
            }
        } catch (\DOMException $exception) {
            throw new \RuntimeException('Unable to build feed element.', previous: $exception);
        }

        $this->document->appendChild($feedElement);
    }

    /**
     * @param Entry[] $entries
     */
    public function addEntriesToFeedElement(array $entries): void
    {
        $feed = $this->document->getElementsByTagName('feed')[0];

        if (!$feed instanceof \DOMElement) {
            throw new \RuntimeException('Feed element does not exist.');
        }

        foreach ($entries as $entry) {
            try {
                $node = $this->document->createElement('entry');
                $node->appendChild(new \DOMElement('id', $entry->getId()));
                $node->appendChild(new \DOMElement('title', $entry->getTitle()));
                $node->appendChild(new \DOMElement('updated', $entry->getUpdated()->format(\DATE_ATOM)));

                if (null !== $entry->getContent()) {
                    $text = $this->document->createTextNode($entry->getContent()->getContent());
                    $element = $this->document->createElement('content');
                    $element->setAttribute('type', $entry->getContent()->getType());
                    $element->appendChild($text);

                    $node->appendChild($element);
                }
            } catch (\DOMException $exception) {
                throw new \RuntimeException('Unable to build feed element.', previous: $exception);
            }

            $feed->appendChild($node);
        }
    }
}
