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

namespace RushlowDevelopment\Atom\Collection;

use RushlowDevelopment\Atom\Model\Person;

final class PersonCollection extends AbstractCollection
{
    public function addPerson(Person $person): void
    {
        $this->offsetSet($person->getName(), $person);
    }

    public function removePerson(Person $person): void
    {
        $this->offsetUnset($person->getName());
    }

    public function getPerson(string $name): Person
    {
        return $this->offsetGet($name);
    }
}
