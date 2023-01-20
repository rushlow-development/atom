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

namespace RushlowDevelopment\Atom;

use RushlowDevelopment\Atom\Collection\PersonCollection;
use RushlowDevelopment\Atom\Generator\AtomXmlGenerator;
use RushlowDevelopment\Atom\Model\Atom;
use RushlowDevelopment\Atom\Model\Entry;
use RushlowDevelopment\Atom\Model\Feed;
use RushlowDevelopment\Atom\Model\Link;
use RushlowDevelopment\Atom\Model\Person;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class AtomBuilder
{
    public function __construct(
        private Atom $atom,
        private AtomXmlGenerator $generator,
    ) {
    }

    public static function createFeed(
        string $id,
        string $title,
        \DateTimeInterface $lastUpdated,
         null|Link $link = null,
        null|string $subtitle = null,
        null|Person|PersonCollection $author = null,
    ): self {
        $feed = new Feed($id, $title, $lastUpdated);

        if (null !== $link) {
            $feed->setLink($link);
        }

        if (null !== $subtitle) {
            $feed->setSubtitle($subtitle);
        }

        if (null !== $author) {
            $feed->setAuthor($author);
        }

        $atom = (new Atom())->setFeedElement($feed);

        return new self($atom, new AtomXmlGenerator());
    }

    public function addEntry(Entry $entry): self
    {
        $this->atom->addEntryElement($entry);

        return $this;
    }

    public function generate(bool $formatOutput = true): string
    {
        $this->generator->buildFeedElement($this->atom->getFeedElement());
        $this->generator->addEntriesToFeedElement($this->atom->getEntryElements());

        $domDocument = $this->generator->getDocument();
        $domDocument->formatOutput = $formatOutput;

        return $domDocument->saveXML();
    }
}
