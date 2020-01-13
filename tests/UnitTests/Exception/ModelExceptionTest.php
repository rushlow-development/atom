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

namespace Geeshoe\Atom\UnitTests\Exception;

use Geeshoe\Atom\Contract\AtomExceptionInterface;
use Geeshoe\Atom\Exception\ModelException;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelExceptionTest
 *
 * @package Geeshoe\Atom\UnitTests\Exception
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class ModelExceptionTest extends TestCase
{
    public function testModelExceptionImplementsAtomExceptionInterface(): void
    {
        $implements = class_implements(ModelException::class);

        $this->assertArrayHasKey(AtomExceptionInterface::class, $implements);
    }

    public function testModelExceptionIsInstanceOfRuntimeException(): void
    {
        $this->assertInstanceOf(\RuntimeException::class, new ModelException());
    }

    public function testModelExceptionHasMethodEmptyPropertyException(): void
    {
        $this->assertTrue(method_exists(ModelException::class, 'emptyPropertyException'));
    }

    public function testEmptyPropertyExceptionThrowsNewModelException(): void
    {
        $this->expectException(ModelException::class);

        throw ModelException::emptyPropertyException('');
    }

    public function testEmptyPropertyExceptionContainsMessage(): void
    {
        $this->expectExceptionMessage('value is empty or uninitialized');

        throw ModelException::emptyPropertyException('');
    }

    public function testEmptyPropertyExceptionPassesMessageParamToMessage(): void
    {
        $this->expectExceptionMessage('Some::property value is empty or uninitialized');

        throw ModelException::emptyPropertyException('Some::property');
    }

    public function testEmptyPropertyExceptionPassesPreviousThrowable(): void
    {
        $exception = new \Exception('previous');

        $previous = null;

        try {
            throw ModelException::emptyPropertyException('', $exception);
        } catch (ModelException $ex) {
            $previous = $ex->getPrevious();
        }

        $this->assertSame($exception, $previous);
    }
}
