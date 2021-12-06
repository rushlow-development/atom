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

namespace RushlowDevelopment\Atom\Generator;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
trait ElementTrait
{
    protected \DOMDocument $dom;

    public function __construct(\DOMDocument $dom)
    {
        $this->dom = $dom;
    }

    public function getIdElement(string $id): \DOMElement
    {
        return $this->dom->createElement('id', $id);
    }

    public function getTitleElement(string $title): \DOMElement
    {
        return $this->dom->createElement('title', $title);
    }

    public function getUpdatedElement(string $timeStampString): \DOMElement
    {
        return $this->dom->createElement('updated', $timeStampString);
    }
}
