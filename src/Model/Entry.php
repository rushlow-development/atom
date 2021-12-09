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

namespace RushlowDevelopment\Atom\Model;

use RushlowDevelopment\Atom\Collection\PersonCollection;
use RushlowDevelopment\Atom\Contract\CollectionInterface;
use RushlowDevelopment\Atom\Contract\EntryInterface;
use RushlowDevelopment\Atom\Exception\ModelException;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class Entry implements EntryInterface
{
    // Recommended Optional Elements
    private PersonCollection $author;
    private ?Content $content = null;
    private ?Link $link;
    private ?string $summary;

    // Optional Elements
    private ?CollectionInterface $category;
    private ?PersonCollection $contributor;
    private ?\DateTimeInterface $published;
    private ?string $rights;
    private ?string $source;


    /**
     * @param string             $id      unique permanent feed URI
     * @param string             $title   human readable title of the feed
     * @param \DateTimeInterface $updated time of last significant feed modification
     */
    public function __construct(
        private string $id,
        private string $title,
        private \DateTimeInterface $updated
    ) {
        $this->author = new PersonCollection();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RushlowDevelopment\Atom\Exception\ModelException;
     */
    public function getId(): string
    {
        if (!empty($this->id)) {
            return $this->id;
        }

        throw ModelException::emptyPropertyException('Id');
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RushlowDevelopment\Atom\Exception\ModelException;
     */
    public function getTitle(): string
    {
        if (!empty($this->title)) {
            return $this->title;
        }

        throw ModelException::emptyPropertyException('Title');
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdated(): \DateTimeInterface
    {
        return $this->updated;
    }

    public function getAuthor(): PersonCollection
    {
        return $this->author;
    }

    public function setAuthor(PersonCollection $author): void
    {
        $this->author = $author;
    }
}
