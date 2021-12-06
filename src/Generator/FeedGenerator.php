<?php

declare(strict_types=1);

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

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class FeedGenerator
{
    use ElementTrait;

    public function getFeed(string $id, string $title, string $updated): \DOMElement
    {
        $feed = $this->createFeedElement();
        $feed->appendChild($this->getIdElement($id));
        $feed->appendChild($this->getTitleElement($title));
        $feed->appendChild($this->getUpdatedElement($updated));

        return $feed;
    }

    public function createFeedElement(): \DOMElement
    {
        $feed = $this->dom->createElementNS(
            'http://www.w3.org/2005/Atom',
            'feed'
        );

        $feed->setAttribute('id', 'feed');

        $feed->setIdAttribute('id', true);

        return $feed;
    }
}
