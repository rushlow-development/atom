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

namespace Geeshoe\Atom\Model;

use Geeshoe\Atom\Contract\ElementInterface;

/**
 * Class Author
 *
 * @package Geeshoe\Atom\Model
 * @author  Jesse Rushlow <jr@geeshoe.com>
 */
class Author implements ElementInterface
{
    private string $name;
    private ?string $uri;
    private ?string $email;

    public function __construct(string $name, string $uri = null, string $email = null)
    {
        $this->name = $name;
        $this->uri = $uri;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
