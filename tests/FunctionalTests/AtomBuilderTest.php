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

namespace RushlowDevelopment\Atom\FunctionalTests;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\AtomBuilder;
use RushlowDevelopment\Atom\Model\Content;
use RushlowDevelopment\Atom\Model\Entry;
use RushlowDevelopment\Atom\Model\Link;
use RushlowDevelopment\Atom\Model\Person;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class AtomBuilderTest extends TestCase
{
    public function testStaticCreateFeed(): void
    {
        $result = AtomBuilder::createFeed('id', 'title', new \DateTimeImmutable());

        self::assertInstanceOf(AtomBuilder::class, $result);
    }

    public function testStaticCreateFeedWithOptionalArguments(): void
    {
        $builder = AtomBuilder::createFeed(
            id: 'https://rushlow.dev',
            title: 'Rushlow.dev XMLGenerator Test',
            lastUpdated: new \DateTimeImmutable('2023-01-17T23:00:00+00:00'),
            link: new Link('https://rushlow.dev/feed'),
            subtitle: 'XMLGenerator Feed Test',
            author: new Person('Jesse Rushlow')
        );

        self::assertSame($this->getExpectedXml('feed-no-entries.xml'), $builder->generate());
    }

    public function testEntryAddedToFeed(): void
    {
        $builder = AtomBuilder::createFeed(
            id: 'https://rushlow.dev',
            title: 'Rushlow.dev XMLGenerator Test',
            lastUpdated: new \DateTimeImmutable('2023-01-17T23:00:00+00:00')
        );

        $entry = (new Entry('https://rushlow.dev/some-link', 'Entry Test Title', new \DateTimeImmutable('2023-01-20T23:00:00+00:00')))
            ->setContent(new Content('<p>Howdy!</p>', Content::TYPE_HTML))
            ->setAuthor(new Person('Jesse Rushlow'))
        ;

        $builder->addEntry($entry);

        self::assertSame($this->getExpectedXml('feed-with-entry.xml'), $builder->generate());
    }

    public function testExceptionThrownIfMissingAuthors(): void
    {
        $builder = AtomBuilder::createFeed('id', 'title', new \DateTimeImmutable());
        $builder->setValidateFeed(false);

        // No exception should be thrown.
        $builder->generate();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Feed is not compliant with Atom 1.0 Specification - Missing Author(s) in either the atom:feed or atom:entry.');

        $builder->setValidateFeed(true);
        $builder->generate();
    }

    private function getExpectedXml(string $filename): string
    {
        return file_get_contents(sprintf('%s/Fixture/expected/%s', __DIR__, $filename));
    }
}
