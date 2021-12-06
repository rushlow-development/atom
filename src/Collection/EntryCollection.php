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

namespace RushlowDevelopment\Atom\Collection;

use Geeshoe\Atom\Model\Entry;

final class EntryCollection extends AbstractCollection
{
    public function addEntry(Entry $entry): void
    {
        $this->offsetSet($entry->getId(), $entry);
    }

    public function removeEntry(Entry $entry): void
    {
        $this->offsetUnset($entry->getId());
    }

    public function getEntry(string $id): Entry
    {
        return $this->offsetGet($id);
    }
}
