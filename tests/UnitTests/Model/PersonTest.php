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

namespace Geeshoe\Atom\UnitTests\Model;

use Geeshoe\Atom\Model\Person;
use Geeshoe\Atom\UnitTests\AbstractModelTest;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
final class PersonTest extends AbstractModelTest
{
    protected function setUp(): void
    {
        $this->classUnderTest = Person::class;
    }

    public function requiredPropertyPerRFCDataProvider(): \Generator
    {
        yield 'Name property' => ['name'];
    }

    public function optionalPropertyPerRFCDataProvider(): \Generator
    {
        yield 'Email property' => ['email'];
        yield 'Uri property' => ['uri'];
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
        self::assertTrue(method_exists(Person::class, $methodName));
    }

    public function testAllPropertiesAreInitializedWithConstructor(): void
    {
        $author = new Person('');

        self::assertSame('', $author->getName());
        self::assertNull($author->getUri());
        self::assertNull($author->getEmail());
    }

    public function testConstructorPassesOptionalParamsToProperties(): void
    {
        $name = 'unit test';
        $uri = 'https://geeshoe.com/';
        $email = 'jr@rushlow.dev';

        $author = new Person($name, $uri, $email);

        self::assertSame($name, $author->getName());
        self::assertSame($uri, $author->getUri());
        self::assertSame($email, $author->getEmail());
    }

    public function setterDataProvider(): array
    {
        return [
            'Person Uri Setter Test' => [
                'getUri', 'setUri', 'https://geeshoe.com',
            ],
            'Person Email Setter Test' => [
                'getEmail', 'setEmail', 'jr@rushlow.dev',
            ],
        ];
    }

    /**
     * @dataProvider setterDataProvider
     */
    public function testAuthorSettersSetGivenParamToProperty(string $getter, string $setter, string $expected): void
    {
        $author = new Person('');

        $author->$setter($expected);
        self::assertSame($expected, $author->$getter());
    }
}
