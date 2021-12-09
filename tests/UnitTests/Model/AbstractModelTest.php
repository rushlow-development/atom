<?php

namespace RushlowDevelopment\Atom\UnitTests\Model;

use PHPUnit\Framework\TestCase;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
abstract class AbstractModelTest extends TestCase
{
    protected function getModelName(): string
    {
        throw new \RuntimeException('AbstractModelTest::getModelName() must return the name of the model under test. e.g. Person::class');
    }

    abstract public function requiredModelPropertiesPerRFCDataProvider(): \Generator;
    abstract public function optionalModelPropertiesPerRFCDataProvider(): \Generator;

    /** @dataProvider requiredModelPropertiesPerRFCDataProvider */
    public function testModelHasRequiredProperties(string $propertyName): void
    {
        $reflectedModel = new \ReflectionClass($this->getModelName());

        self::assertTrue($reflectedModel->hasProperty($propertyName));
    }

    /** @dataProvider optionalModelPropertiesPerRFCDataProvider */
    public function testModelHasOptionalProperties(string $propertyName): void
    {
        $reflectedModel = new \ReflectionClass($this->getModelName());

        self::assertTrue($reflectedModel->hasProperty($propertyName));
    }
}
