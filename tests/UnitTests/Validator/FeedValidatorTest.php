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

namespace RushlowDevelopment\Atom\UnitTests\Validator;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Model\Atom;
use RushlowDevelopment\Atom\Model\Entry;
use RushlowDevelopment\Atom\Model\Feed;
use RushlowDevelopment\Atom\Model\Person;
use RushlowDevelopment\Atom\Validator\FeedValidator;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class FeedValidatorTest extends TestCase
{
    public function testAuthorRequirement(): void
    {
        $atom = new Atom();
        $atom->setFeedElement($feed = new Feed('id', 'test', new \DateTimeImmutable()));

        self::assertFalse(FeedValidator::hasRequiredAuthors($atom), 'Feed does not have an author. (No Entries)');

        $feed->setAuthor(new Person('Jesse Rushlow'));

        self::assertTrue(FeedValidator::hasRequiredAuthors($atom), 'Feed has an author. (No Entries)');

        $atom = new Atom();
        $atom->setFeedElement(new Feed('id', 'test', new \DateTimeImmutable()));

        $entry = new Entry('id', 'title', new \DateTimeImmutable());
        $atom->addEntryElement($entry);

        self::assertFalse(FeedValidator::hasRequiredAuthors($atom), 'Entry does not have an author. (No Feed Author)');

        $entry->setAuthor(new Person('Jesse Rushlow'));

        self::assertTrue(FeedValidator::hasRequiredAuthors($atom), 'Entry has an author. (No Feed Author)');

        $atom->addEntryElement(new Entry('id', 'title', new \DateTimeImmutable()));

        self::assertFalse(FeedValidator::hasRequiredAuthors($atom), 'Only 1 entry has an author. (No Feed Author)');
    }
}
