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

namespace RushlowDevelopment\Atom\Factory;

use RushlowDevelopment\Atom\Exception\FactoryException;
use RushlowDevelopment\Atom\Model\Feed;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class FeedFactory
{
    public static function createFeed(string $id, string $title, \DateTimeInterface $updated): Feed
    {
        if (self::validateRequiredFeedElements($id, $title)) {
            return new Feed($id, $title, $updated);
        }

        throw FactoryException::requiredException();
    }

    protected static function validateRequiredFeedElements(string $id, string $title): bool
    {
        return !empty($id) && !empty($title);
    }
}
