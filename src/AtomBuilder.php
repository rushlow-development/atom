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

namespace Geeshoe\Atom;

use Geeshoe\Atom\Contract\BuilderInterface;
use Geeshoe\Atom\Contract\GeneratorInterface;
use Geeshoe\Atom\Factory\AuthorFactory;
use Geeshoe\Atom\Factory\EntryFactory;
use Geeshoe\Atom\Factory\FeedFactory;
use Geeshoe\Atom\Generator\XMLGenerator;
use Geeshoe\Atom\Model\Atom;

/**
 * Class AtomBuilder
 *
 * @package Geeshoe\Atom
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class AtomBuilder implements BuilderInterface
{
    private Atom $atom;
    private GeneratorInterface $generator;

    /**
     * AtomBuilder constructor.
     *
     * @param Atom|null               $atom
     * @param GeneratorInterface|null $generator
     */
    public function __construct(Atom $atom = null, GeneratorInterface $generator = null)
    {
        if ($atom === null) {
            $atom = new Atom();
        }

        if ($generator === null) {
            $generator = new XMLGenerator();
        }

        $this->atom = $atom;
        $this->generator = $generator;
    }

    /**
     * @@inheritDoc
     */
    public function getAtom(): Atom
    {
        return $this->atom;
    }

    /**
     * @inheritDoc
     */
    public function createFeed(string $id, string $title, \DateTimeInterface $lastUpdated): void
    {
        $this->atom->setFeedElement(FeedFactory::createFeed($id, $title, $lastUpdated));
    }

    public function addFeedAuthor(string $name, string $uri = null, string $email = null): void
    {
        $author = AuthorFactory::createAuthor($name, $uri, $email);

        $feed = $this->atom->getFeedElement();
        $feed->addAuthor($author);

        $this->atom->setFeedElement($feed);
    }

    /**
     * @inheritDoc
     */
    public function addEntry(string $id, string $title, \DateTimeInterface $lastUpdated): void
    {
        $this->atom->addEntryElement(EntryFactory::createEntry($id, $title, $lastUpdated));
    }

    /**
     * @inheritDoc
     */
    public function publish(): string
    {
        $this->generator->initialize($this->atom->getFeedElement());

        foreach ($this->atom->getEntryElements() as $entryElement) {
            $this->generator->addEntry($entryElement);
        }

        return $this->generator->generate();
    }
}
