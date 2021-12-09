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
    private ?Link $link = null;
    private ?string $summary = null;

    // Optional Elements
    private ?CollectionInterface $category = null;
    private ?PersonCollection $contributor = null;
    private ?\DateTimeInterface $published = null;
    private ?string $rights = null;
    private ?string $source = null;

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

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): void
    {
        $this->content = $content;
    }

    public function getLink(): ?Link
    {
        return $this->link;
    }

    public function setLink(?Link $link): void
    {
        $this->link = $link;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
    }

    public function getCategory(): ?CollectionInterface
    {
        return $this->category;
    }

    public function setCategory(?CollectionInterface $category): void
    {
        $this->category = $category;
    }

    public function getContributor(): ?PersonCollection
    {
        return $this->contributor;
    }

    public function setContributor(?PersonCollection $contributor): void
    {
        $this->contributor = $contributor;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(?\DateTimeInterface $published): void
    {
        $this->published = $published;
    }

    public function getRights(): ?string
    {
        return $this->rights;
    }

    public function setRights(?string $rights): void
    {
        $this->rights = $rights;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): void
    {
        $this->source = $source;
    }
}
