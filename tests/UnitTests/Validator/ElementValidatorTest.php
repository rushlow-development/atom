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
use RushlowDevelopment\Atom\Exception\ValidatorException;
use RushlowDevelopment\Atom\Validator\ElementValidator;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 *
 * @internal
 */
class ElementValidatorTest extends TestCase
{
    public function testValidIdElementThrowsExceptionWithInvalidIRI(): void
    {
        $this->expectException(ValidatorException::class);

        ElementValidator::validIdElement(':');
    }

    public function testValidIdElementReturnsTrueWithValidIRISupplied(): void
    {
        self::assertTrue(ElementValidator::validIdElement('http://r&#xE9;sum&#xE9;.example.org'));
    }

    public function testValidIdElementThrowsExceptionWithEmptyId(): void
    {
        $this->expectException(ValidatorException::class);

        ElementValidator::validIdElement('');
    }

    public function testValidTitleElementThrowsExceptionWithInvalidTitle(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('Title represents a atom:title element and therefor must not be empty.');

        ElementValidator::validTitleElement('');
    }

    public function testValidTitleElementReturnsTrueWithNonEmptyString(): void
    {
        $this->assertTrue(ElementValidator::validTitleElement('valid'));
    }
}
