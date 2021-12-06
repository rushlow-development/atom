<?php

namespace RushlowDevelopment\Atom\UnitTests;

use RushlowDevelopment\Atom\Contract\ModelUnitTestInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractModelTest extends TestCase implements ModelUnitTestInterface
{
    protected string $classUnderTest;

    /**
     * @dataProvider requiredPropertyPerRFCDataProvider
     */
    public function testHasRequiredPropertyPerRFC(string $propertyName): void
    {
        self::assertClassHasAttribute($propertyName, $this->classUnderTest, $this->getPropertyErrorMessage($propertyName));
    }

    /**
     * @dataProvider optionalPropertyPerRFCDataProvider
     */
    public function testHasOptionalPropertyPerRFC(string $propertyName): void
    {
        self::assertClassHasAttribute($propertyName, $this->classUnderTest, $this->getPropertyErrorMessage($propertyName));
    }

    private function getPropertyErrorMessage(string $property): string
    {
        return sprintf('%s does not have %s property defined as required to comply with RFC4287', $property, $this->classUnderTest);
    }
}
