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

namespace Geeshoe\Atom\Generator;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class EntryGenerator
{
    use ElementTrait;

    public function getEntry(string $id, string $title, string $updated): \DOMElement
    {
        $entry = $this->dom->createElement('entry');

        $entry->appendChild($this->getIdElement($id));
        $entry->appendChild($this->getTitleElement($title));
        $entry->appendChild($this->getUpdatedElement($updated));

        return $entry;
    }
}
