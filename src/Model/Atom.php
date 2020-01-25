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

use Geeshoe\Atom\Contract\EntryInterface;
use Geeshoe\Atom\Contract\FeedInterface;
use Geeshoe\Atom\Exception\ModelException;

/**
 * Class Atom
 *
 * @package Geeshoe\Atom\Model
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class Atom
{
    private FeedInterface $feedElement;

    private array $entryElements = [];

    /**
     * @param FeedInterface $feed
     */
    public function setFeedElement(FeedInterface $feed): void
    {
        $this->feedElement = $feed;
    }

    /**
     * @return FeedInterface
     */
    public function getFeedElement(): FeedInterface
    {
        if (isset($this->feedElement)) {
            return $this->feedElement;
        }

        throw ModelException::emptyPropertyException('Feed');
    }

    /**
     * @param EntryInterface $entryElement
     */
    public function addEntryElement(EntryInterface $entryElement): void
    {
        $this->entryElements[] = $entryElement;
    }

    /**
     * @return array
     */
    public function getEntryElements(): array
    {
        return $this->entryElements;
    }
}
