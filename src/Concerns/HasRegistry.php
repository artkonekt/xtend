<?php

declare(strict_types=1);

/**
 * Contains the HasRegistry trait.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend\Concerns;

use Konekt\Extend\Contracts\Registerable;

trait HasRegistry
{
    protected static array $registry = [];

    public static function add(string $id, string $class): bool
    {
        if (array_key_exists($id, static::$registry)) {
            return false;
        }

        static::override($id, $class);

        return true;
    }

    public static function override(string $id, string $class): void
    {
        static::validate($class);
        static::$registry[$id] = $class;
    }

    public static function getClassOf(string $id): ?string
    {
        return static::$registry[$id] ?? null;
    }

    public static function getIdOf(string $class): ?string
    {
        $result = array_search($class, static::$registry, true);

        return false === $result ? null : $result;
    }

    public static function delete(string $id): bool
    {
        if (!array_key_exists($id, static::$registry)) {
            return false;
        }

        unset(static::$registry[$id]);

        return true;
    }

    public static function deleteClass(string $class): int
    {
        $toDelete = [];
        foreach (static::$registry as $id => $entry) {
            if ($entry === $class) {
                $toDelete[] = $id;
            }
        }
        foreach ($toDelete as $id) {
            unset(static::$registry[$id]);
        }

        return count($toDelete);
    }

    public static function reset(): void
    {
        static::$registry = [];
    }

    public static function ids(): array
    {
        return array_keys(static::$registry);
    }

    public static function choices(): array
    {
        $result = [];

        foreach (self::$registry as $id => $class) {
            $result[$id] = match (is_subclass_of($class, Registerable::class) || method_exists($class, 'getName')) {
                true => $class::getName(),
                default => $class,
            };
        }

        return $result;
    }

    abstract protected static function validate(string $class): void;
}
