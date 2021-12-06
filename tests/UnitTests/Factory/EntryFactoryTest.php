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

namespace RushlowDevelopment\Atom\UnitTests\Factory;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Contract\EntryInterface;
use RushlowDevelopment\Atom\Exception\FactoryException;
use RushlowDevelopment\Atom\Factory\EntryFactory;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class EntryFactoryTest extends TestCase
{
    public function testCreateEntryReturnsValidEntryModel(): void
    {
        $result = EntryFactory::createEntry('testId', 'test title', new \DateTime());

        self::assertInstanceOf(EntryInterface::class, $result);
    }

    /**
     * @return array<array> [['id', 'title', expectedBook]]
     */
    public function validateRequiredDataProvider(): array
    {
        return [
            ['id', 'title', true],
            ['', 'title', false],
            ['id', '', false],
            ['', '', false],
        ];
    }

    /**
     * @dataProvider validateRequiredDataProvider
     *
     * @throws \Exception
     */
    public function testCreateEntryThrowsExceptionOnEmptyParams(string $id, string $title, bool $expected): void
    {
        if (!$expected) {
            $this->expectException(FactoryException::class);
            $this->expectExceptionMessage(FactoryException::REQUIRED_MSG);
        } else {
            $this->expectNotToPerformAssertions();
        }

        EntryFactory::createEntry($id, $title, new \DateTime());
    }
}
