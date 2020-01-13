<?php

/**
 * Copyright 2020 Jesse Rushlow - Geeshoe Development
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

namespace Geeshoe\Atom\UnitTests\Factory;

use Geeshoe\Atom\Contract\FeedRequiredInterface;
use Geeshoe\Atom\Exception\FactoryException;
use Geeshoe\Atom\Factory\FeedFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class FeedFactoryTest
 *
 * @package Geeshoe\Atom\UnitTests\Factory
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class FeedFactoryTest extends TestCase
{
    public function testCreateFeedReturnsValidFeedModel(): void
    {
        $result = FeedFactory::createFeed('testId', 'test title', new \DateTime());

        self::assertInstanceOf(FeedRequiredInterface::class, $result);
    }

    /**
     * @return array<array> [['id', 'title', expectedBool]]
     */
    public function validateRequiredDataProvider(): array
    {
        return [
            ['id', 'title', true],
            ['', 'title', false],
            ['id', '', false],
            ['', '', false]
        ];
    }

    /**
     * @dataProvider validateRequiredDataProvider
     * @param string $id
     * @param string $title
     * @param bool   $expected
     * @throws \Exception
     */
    public function testCreateFeedThrowsExceptionOnEmptyParams(string $id, string $title, bool $expected): void
    {
        if (!$expected) {
            $this->expectException(FactoryException::class);
            $this->expectExceptionMessage(FactoryException::REQUIRED_MSG);
        } else {
            $this->expectNotToPerformAssertions();
        }

        FeedFactory::createFeed($id, $title, new \DateTime());
    }
}
