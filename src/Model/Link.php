<?php

namespace RushlowDevelopment\Atom\Model;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class Link
{
    // Optional
    /** @var string One of alternate, enclosure, related, self, or via */
    public string $rel;
    public string $type;
    public string $hreflang;
    public string $title;
    public string $length;

    public function __construct(
        private string $href
    ) {
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getRel(): string
    {
        return $this->rel;
    }

    public function setRel(string $rel): void
    {
        $this->rel = $rel;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getHreflang(): string
    {
        return $this->hreflang;
    }

    public function setHreflang(string $hreflang): void
    {
        $this->hreflang = $hreflang;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getLength(): string
    {
        return $this->length;
    }

    public function setLength(string $length): void
    {
        $this->length = $length;
    }


}
