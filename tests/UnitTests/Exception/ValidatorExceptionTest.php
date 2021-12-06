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

namespace RushlowDevelopment\Atom\UnitTests\Exception;

use PHPUnit\Framework\TestCase;
use RushlowDevelopment\Atom\Contract\AtomExceptionInterface;
use RushlowDevelopment\Atom\Exception\ValidatorException;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class ValidatorExceptionTest extends TestCase
{
    public function testValidatorExceptionIsInstanceOfInvalidArgumentException(): void
    {
        $this->assertInstanceOf(\InvalidArgumentException::class, new ValidatorException());
    }

    public function testValidatorExceptionImplementsAtomExceptionInterface(): void
    {
        $implements = class_implements(ValidatorException::class);

        $this->assertArrayHasKey(AtomExceptionInterface::class, $implements);
    }

    public function testInvalidTitleSuppliesInvalidTitleConstantAsReturnedExceptionMessage(): void
    {
        $exception = ValidatorException::invalidTitle();

        $this->assertSame(ValidatorException::INVALID_TITLE, $exception->getMessage());
    }

    public function testInvalidTitlePassesPreviousThrowableIfProvided(): void
    {
        $expected = new \Exception('title');

        $this->assertSame($expected, ValidatorException::invalidTitle($expected)->getPrevious());
    }
}
