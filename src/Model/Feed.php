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

namespace Geeshoe\Atom\Model;

use Geeshoe\Atom\Collection\ElementCollection;
use Geeshoe\Atom\Contract\CollectionInterface;
use Geeshoe\Atom\Contract\FeedInterface;
use Geeshoe\Atom\Exception\ModelException;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class Feed implements FeedInterface
{
    private string $id;
    private string $title;
    private \DateTimeInterface $updated;
    private CollectionInterface $author;
    private ?CollectionInterface $category;
    private ?CollectionInterface $contributor;
    private ?string $generator;
    private ?string $icon;
    private ?string $logo;
    private ?CollectionInterface $link;
    private ?string $rights;
    private ?string $subtitle;

    /**
     * Feed constructor.
     *
     * @param string             $id      unique permanent feed URI
     * @param string             $title   human readable title of the feed
     * @param \DateTimeInterface $updated time of last significant feed modification
     */
    public function __construct(string $id, string $title, \DateTimeInterface $updated)
    {
        $this->id = $id;

        $this->title = $title;

        $this->updated = $updated;
        $this->author = new ElementCollection();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Geeshoe\Atom\Exception\ModelException;
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
     * @throws \Geeshoe\Atom\Exception\ModelException;
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

    public function getAuthor(): CollectionInterface
    {
        return $this->author;
    }

    public function setAuthor(CollectionInterface $author): void
    {
        $this->author = $author;
    }
}
