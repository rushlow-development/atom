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

namespace Geeshoe\Atom\Validator;

use Geeshoe\Atom\Exception\ValidatorException;
use League\Uri\Contracts\UriException;
use League\Uri\Uri;

/**
 * Class ElementValidator
 *
 * @package Geeshoe\Atom\Validator
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class ElementValidator
{
    /**
     * Return true if ID is a valid URI/IRI
     *
     * @param string $id
     * @return bool
     */
    public static function validIdElement(string $id): bool
    {
        try {
            Uri::createFromString($id);
            return true;
        } catch (UriException $exception) {
            throw new ValidatorException($exception->getMessage(), 0, $exception);
        }
    }
}
