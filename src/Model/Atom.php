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

use RushlowDevelopment\Atom\Exception\ModelException;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class Atom
{
    private Feed $feedElement;

    /** @var Entry[] */
    private array $entryElements = [];

    public function setFeedElement(Feed $feed): self
    {
        $this->feedElement = $feed;

        return $this;
    }

    public function getFeedElement(): Feed
    {
        if (isset($this->feedElement)) {
            return $this->feedElement;
        }

        throw ModelException::emptyPropertyException('Feed');
    }

    public function addEntryElement(Entry $entryElement): self
    {
        $this->entryElements[] = $entryElement;

        return $this;
    }

    public function getEntryElements(): array
    {
        return $this->entryElements;
    }
}
