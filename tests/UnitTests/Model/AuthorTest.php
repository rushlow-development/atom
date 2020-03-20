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

namespace Geeshoe\Atom\UnitTests\Model;

use Geeshoe\Atom\Model\Author;
use PHPUnit\Framework\TestCase;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class AuthorTest extends TestCase
{
    public function requiredPropertyDataProvider(): array
    {
        return [
            ['name'],
            ['uri'],
            ['email'],
        ];
    }

    /**
     * @dataProvider requiredPropertyDataProvider
     */
    public function testAuthorHasRequiredProperties(string $property): void
    {
        self::assertClassHasAttribute($property, Author::class);
    }

    public function requiredMethodDataProvider(): array
    {
        return [
            ['getName'],
            ['getUri'],
            ['setUri'],
            ['getEmail'],
            ['setEmail'],
        ];
    }

    /**
     * @dataProvider requiredMethodDataProvider
     */
    public function testAuthorHasRequiredMethods(string $methodName): void
    {
        self::assertTrue(\method_exists(Author::class, $methodName));
    }

    public function testAllPropertiesAreInitializedWithConstructor(): void
    {
        $author = new Author('');

        self::assertSame('', $author->getName());
        self::assertNull($author->getUri());
        self::assertNull($author->getEmail());
    }

    public function testConstructorPassesOptionalParamsToProperties(): void
    {
        $name = 'unit test';
        $uri = 'https://geeshoe.com/';
        $email = 'jr@rushlow.dev';

        $author = new Author($name, $uri, $email);

        self::assertSame($name, $author->getName());
        self::assertSame($uri, $author->getUri());
        self::assertSame($email, $author->getEmail());
    }

    public function setterDataProvider(): array
    {
        return [
            'Author Uri Setter Test' => [
                'getUri', 'setUri', 'https://geeshoe.com',
            ],
            'Author Email Setter Test' => [
                'getEmail', 'setEmail', 'jr@rushlow.dev',
            ],
        ];
    }

    /**
     * @dataProvider setterDataProvider
     */
    public function testAuthorSettersSetGivenParamToProperty(string $getter, string $setter, string $expected): void
    {
        $author = new Author('');

        $author->$setter($expected);
        self::assertSame($expected, $author->$getter());
    }
}
