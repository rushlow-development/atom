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

use Rector\Core\Configuration\Option;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $basePath = dirname(__DIR__, 2);

    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        $basePath.'/src',
        $basePath.'/tests',
    ]);

    $parameters->set(Option::BOOTSTRAP_FILES, [
        $basePath.'/vendor/autoload.php',
        $basePath.'/tools/rector/vendor/autoload.php',
    ]);
//    $parameters->set(Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersion::PHP_81);

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::PHP_80);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_91);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
    $services->set(\Rector\DowngradePhp70\Rector\Declare_\DowngradeStrictTypeDeclarationRector::class);
};
