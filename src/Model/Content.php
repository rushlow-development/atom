<?php

namespace RushlowDevelopment\Atom\Model;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class Content
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
        if (!in_array($type, [self::TYPE_TEXT, self::TYPE_HTML, self::TYPE_XHTML])) {
            throw new \RuntimeException('You must use one of Content::TYPE_TEXT, Content::TYPE_HTML, or Content::TYPE_XHTML types.');
        }
    }
}
