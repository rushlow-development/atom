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

namespace Geeshoe\Atom\Model;

use Geeshoe\Atom\Contract\FeedRequiredInterface;
use Geeshoe\Atom\Exception\ModelException;

/**
 * Class Feed
 *
 * @package Geeshoe\Atom\Model
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class Feed implements FeedRequiredInterface
{
    private string $id;

    private string $title;

    private \DateTimeInterface $updated;

    private Author $author;

    /**
     * Feed constructor.
     *
     * @param string             $id      Unique permanent feed URI.
     * @param string             $title   Human readable title of the feed.
     * @param \DateTimeInterface $updated Time of last significant feed modification.
     */
    public function __construct(string $id, string $title, \DateTimeInterface $updated)
    {
        $this->id = $id;

        $this->title = $title;

        $this->updated = $updated;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function getUpdated(): \DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * @throws \Geeshoe\Atom\Exception\ModelException
     */
    public function getAuthor(): Author
    {
        if (!empty($this->author)) {
            return $this->author;
        }

        throw ModelException::emptyPropertyException('Author');
    }

    public function setAuthor(Author $author): void
    {
        $this->author = $author;
    }
}
