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

namespace RushlowDevelopment\Atom\FunctionalTests\Generator;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Collection\PersonCollection;
use RushlowDevelopment\Atom\Generator\AtomXmlGenerator;
use RushlowDevelopment\Atom\Model\Content;
use RushlowDevelopment\Atom\Model\Entry;
use RushlowDevelopment\Atom\Model\Feed;
use RushlowDevelopment\Atom\Model\Link;
use RushlowDevelopment\Atom\Model\Person;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class AtomXmlGeneratorTest extends TestCase
{
    private AtomXmlGenerator $generator;
    private Feed $feedFixture;

    protected function setUp(): void
    {
        $this->generator = new AtomXmlGenerator();
        $this->feedFixture = new Feed(
            id: 'https://rushlow.dev',
            title: 'Rushlow.dev XMLGenerator Test',
            updated: new \DateTimeImmutable('2023-01-17T23:00:00+00:00')
        );
    }

    public function testBuildFeedElementWithRequiredItems(): void
    {
        $this->generator->buildFeedElement($this->feedFixture);

        $result = $this->generator->getDocument();
        $result->formatOutput = true;
        $result = $result->saveXML();

        self::assertSame($this->getExpectedXml('feed-bare-minimum.xml'), $result);
    }

    public function testBuildFeedElementWithOptionalItems(): void
    {
        $this->feedFixture
            ->setSubtitle('XMLGenerator Feed Test')
            ->setLink(new Link('https://rushlow.dev/feed'))
            ->setAuthor(new Person('Jesse Rushlow'))
        ;

        $this->generator->buildFeedElement($this->feedFixture);

        $result = $this->generator->getDocument();
        $result->formatOutput = true;
        $result = $result->saveXML();

        self::assertSame($this->getExpectedXml('feed-no-entries.xml'), $result);
    }

    public function testFeedWithEntries(): void
    {
        $entry = (new Entry('https://rushlow.dev/some-link', 'Entry Test Title', new \DateTimeImmutable('2023-01-20T23:00:00+00:00')))
            ->setContent(new Content('<p>Howdy!</p>', Content::TYPE_HTML))
            ->setAuthor(new Person('Jesse Rushlow'))
        ;

        $this->generator->buildFeedElement($this->feedFixture);
        $this->generator->addEntriesToFeedElement([$entry]);

        $result = $this->generator->getDocument();
        $result->formatOutput = true;
        $result = $result->saveXML();

        self::assertSame($this->getExpectedXml('feed-with-entry.xml'), $result);
    }

    public function testOptionalAuthorDetailsAreAdded(): void
    {
        $this->feedFixture->setAuthor(new Person('Jesse Rushlow', 'https://rushlow.dev', 'jr@rushlow.dev'));

        $entry = (new Entry('id', 'title', new \DateTimeImmutable('2023-01-20T23:00:00+00:00')))
            ->setAuthor(new Person('Jesse Rushlow', 'https://rushlow.dev', 'jr@rushlow.dev'))
        ;

        $this->generator->buildFeedElement($this->feedFixture);
        $this->generator->addEntriesToFeedElement([$entry]);

        $result = $this->generator->getDocument();
        $result->formatOutput = true;
        $result = $result->saveXML();

        self::assertSame($this->getExpectedXml('feed-all-author-fields.xml'), $result);
    }

    public function testMultipleAuthors(): void
    {
        /**
         * <author>.
        </author>
         */
        $authorCollection = (new PersonCollection())
            ->addPerson(new Person('Jesse Rushlow', 'https://rushlow.dev', 'jr@rushlow.dev'))
            ->addPerson(new Person('Someone Else', 'https://their-domain.com', 'not@my-email.com'))
        ;

        $this->feedFixture->setAuthor($authorCollection);

        $entry = (new Entry('id', 'title', new \DateTimeImmutable('2023-01-20T23:00:00+00:00')))
            ->setAuthor($authorCollection)
        ;

        $this->generator->buildFeedElement($this->feedFixture);
        $this->generator->addEntriesToFeedElement([$entry]);

        $result = $this->generator->getDocument();
        $result->formatOutput = true;
        $result = $result->saveXML();

        self::assertSame($this->getExpectedXml('feed-multiple-authors.xml'), $result);
    }

    private function getExpectedXml(string $filename): string
    {
        return file_get_contents(sprintf('%s/Fixture/expected/%s', \dirname(__DIR__), $filename));
    }
}
