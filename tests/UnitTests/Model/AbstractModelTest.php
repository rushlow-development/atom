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

namespace RushlowDevelopment\Atom\UnitTests\Model;

use PHPUnit\Framework\TestCase;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
abstract class AbstractModelTest extends TestCase
{
    protected function getModelName(): string
    {
        throw new \RuntimeException('AbstractModelTest::getModelName() must return the name of the model under test. e.g. Person::class');
    }

    abstract public function requiredModelPropertiesPerRFCDataProvider(): \Generator;

    abstract public function optionalModelPropertiesPerRFCDataProvider(): \Generator;

    /** @dataProvider requiredModelPropertiesPerRFCDataProvider */
    public function testModelHasRequiredProperties(string $propertyName): void
    {
        $reflectedModel = new \ReflectionClass($this->getModelName());

        self::assertTrue($reflectedModel->hasProperty($propertyName));
    }

    /** @dataProvider optionalModelPropertiesPerRFCDataProvider */
    public function testModelHasOptionalProperties(string $propertyName): void
    {
        $reflectedModel = new \ReflectionClass($this->getModelName());

        self::assertTrue($reflectedModel->hasProperty($propertyName));
    }
}
