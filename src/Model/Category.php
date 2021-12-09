<?php

namespace RushlowDevelopment\Atom\Model;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class Category
{
    // Optional
    private ?string $scheme = null;
    private ?string $label = null;

    public function __construct(
        private string $term
    ) {
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    public function getScheme(): ?string
    {
        return $this->scheme;
    }

    public function setScheme(?string $scheme): void
    {
        $this->scheme = $scheme;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }


}
