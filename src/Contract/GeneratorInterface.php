<?php

declare(strict_types=1);

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

namespace RushlowDevelopment\Atom\Contract;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
interface GeneratorInterface
{
    /**
     * Create Atom 1.0 Feed element.
     */
    public function initialize(FeedInterface $feed): void;

    /**
     * Add Atom 1.0 Entry element to the Feed element.
     */
    public function addEntry(EntryInterface $entry): void;

    /**
     * Get the Atom 1.0 document.
     */
    public function generate(): string;
}
