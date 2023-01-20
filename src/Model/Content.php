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

namespace RushlowDevelopment\Atom\Model;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class Content
{
    public const TYPE_TEXT = 'text';
    public const TYPE_HTML = 'html';
    public const TYPE_XHTML = 'xhtml';

    private string $type;

    public function __construct(
        private string $content,
        string $type = self::TYPE_TEXT
    ) {
        $this->validate($type);

        $this->type = $type;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->validate($type);

        $this->type = $type;
    }

    private function validate(string $type): void
    {
        if (!\in_array($type, [self::TYPE_TEXT, self::TYPE_HTML, self::TYPE_XHTML])) {
            throw new \RuntimeException('You must use one of Content::TYPE_TEXT, Content::TYPE_HTML, or Content::TYPE_XHTML types.');
        }
    }
}
