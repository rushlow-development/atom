<?php

namespace RushlowDevelopment\Atom\UnitTests\Model;

use RushlowDevelopment\Atom\Model\Link;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class LinkTest extends AbstractModelTest
{
    public function requiredModelPropertiesPerRFCDataProvider(): \Generator
    {
        yield ['href'];
    }

    public function optionalModelPropertiesPerRFCDataProvider(): \Generator
    {
        yield ['rel'];
        yield ['type'];
        yield ['hreflang'];
        yield ['title'];
        yield ['length'];
    }

    protected function getModelName(): string
    {
        return Link::class;
    }
}
