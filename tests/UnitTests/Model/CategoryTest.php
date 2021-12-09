<?php

namespace RushlowDevelopment\Atom\UnitTests\Model;

use RushlowDevelopment\Atom\Model\Category;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
class CategoryTest extends AbstractModelTest
{
    public function requiredModelPropertiesPerRFCDataProvider(): \Generator
    {
        yield ['term'];
    }

    public function optionalModelPropertiesPerRFCDataProvider(): \Generator
    {
        yield ['scheme'];
        yield ['label'];
    }

    protected function getModelName(): string
    {
        return Category::class;
    }
}
