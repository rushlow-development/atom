<?php

namespace Geeshoe\Atom\Contract;

interface ModelUnitTestInterface
{
    public function testHasRequiredPropertyPerRFC(string $propertyName): void;

    public function requiredPropertyPerRFCDataProvider(): \Generator;

    public function testHasOptionalPropertyPerRFC(string $propertyName): void;

    public function optionalPropertyPerRFCDataProvider(): \Generator;
}
