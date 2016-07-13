<?php

namespace RRaven\GSB;

use DI\ContainerBuilder;
use DI\Container as DIContainer;

/**
 * Class Container
 * Dependency injection container for use in other classes
 *
 * @package RRaven\GSB
 */
class Container {
    private static $container;

    /**
     * @return DIContainer
     */
    public static function getInstance()
    {
        if (static::$container === null) {
            static::$container = ContainerBuilder::buildDevContainer();
        }

        return static::$container;
    }
}
