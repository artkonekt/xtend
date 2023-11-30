<?php

declare(strict_types=1);

/**
 * Contains the RequiresClassOrInterface trait.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend\Concerns;

trait RequiresClassOrInterface
{
    protected static function validate(string $class): void
    {
        if (property_exists(static::class, 'requiredInterface')) {
            if (in_array(static::$requiredInterface, class_implements($class))) {
                return;
            }

            throw new \InvalidArgumentException(
                sprintf('The class you are trying to register (%s) must implement the %s interface.', $class, static::$requiredInterface)
            );
        }

        if (property_exists(static::class, 'requiredClass')) {
            if (in_array(static::$requiredClass, class_parents($class)) || $class === static::$requiredClass) {
                return;
            }

            throw new \InvalidArgumentException(
                sprintf('The class you are trying to register (%s) must be a(n) %s.', $class, static::$requiredClass)
            );
        }

        throw new \LogicException(sprintf('The %s class must define either the `$requiredInterface` or the `$requiredClass` static property', static::class));
    }
}
