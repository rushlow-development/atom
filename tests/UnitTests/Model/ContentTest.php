<?php

namespace RushlowDevelopment\Atom\UnitTests\Model;

use RushlowDevelopment\Atom\Model\Content;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class ContentTest extends AbstractModelTest
{
    public function requiredModelPropertiesPerRFCDataProvider(): \Generator
    {
        yield ['content'];
    }

    public function optionalModelPropertiesPerRFCDataProvider(): \Generator
    {
        yield ['type'];
    }

    protected function getModelName(): string
    {
        return Content::class;
    }
}
