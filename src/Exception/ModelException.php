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

namespace RushlowDevelopment\Atom\Exception;

use RushlowDevelopment\Atom\Contract\AtomExceptionInterface;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class ModelException extends \RuntimeException implements AtomExceptionInterface
{
    public static function emptyPropertyException(string $propertySignature, \Throwable $previous = null): self
    {
        return new self("$propertySignature value is empty or uninitialized", 0, $previous);
    }
}
