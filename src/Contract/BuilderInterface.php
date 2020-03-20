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

namespace Geeshoe\Atom\Contract;

use Geeshoe\Atom\Model\Atom;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
interface BuilderInterface
{
    /**
     * Get representation of all required Atom 1.0 elements.
     */
    public function getAtom(): Atom;

    /**
     * Create the Feed element required for Atom 1.0.
     */
    public function createFeed(string $id, string $title, \DateTimeInterface $lastUpdated): void;

    /**
     * Add a entry element for a Atom 1.0 feed.
     */
    public function addEntry(string $id, string $title, \DateTimeInterface $lastUpdated): void;

    /**
     * Get Atom XML string.
     */
    public function publish(): string;
}
