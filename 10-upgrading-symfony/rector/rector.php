<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src'
    ]);

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::DEAD_CODE);

    $parameters->set(
        Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER,
        __DIR__ . '/app/cache/dev/appDevDebugProjectContainer.xml'
    );
    // endregion

    $containerConfigurator->import(SymfonySetList::SYMFONY_28);
    $containerConfigurator->import(SetList::PHP_70);
    $containerConfigurator->import(SymfonySetList::SYMFONY_30);
    $containerConfigurator->import(SymfonySetList::SYMFONY_31);
    $containerConfigurator->import(SymfonySetList::SYMFONY_32);
    $containerConfigurator->import(SymfonySetList::SYMFONY_33);
    $containerConfigurator->import(SymfonySetList::SYMFONY_34);
    $containerConfigurator->import(SymfonySetList::SYMFONY_40);
    $containerConfigurator->import(SymfonySetList::SYMFONY_41);
    $containerConfigurator->import(SymfonySetList::SYMFONY_42);
    $containerConfigurator->import(SymfonySetList::SYMFONY_43);
    $containerConfigurator->import(SymfonySetList::SYMFONY_44);
    $containerConfigurator->import(SymfonySetList::SYMFONY_50);
    $containerConfigurator->import(SymfonySetList::SYMFONY_50_TYPES);
    $containerConfigurator->import(SymfonySetList::SYMFONY_52);
    $containerConfigurator->import(SymfonySetList::SYMFONY_52_VALIDATOR_ATTRIBUTES);
    $containerConfigurator->import(SetList::PHP_80);
    $containerConfigurator->import(SymfonySetList::SYMFONY_CODE_QUALITY);
    $containerConfigurator->import(SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION);
    $containerConfigurator->import(SetList::PHP_81);
};
