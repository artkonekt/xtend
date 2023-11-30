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

trait HasRegistry
{
    protected static array $registry = [];

    public static function add(string $id, string $class): bool
    {
        if (array_key_exists($id, self::$registry)) {
            return false;
        }

        static::validate($class);

        self::$registry[$id] = $class;

        return true;
    }

    public static function override(string $id, string $class): void
    {
        static::validate($class);

        self::$registry[$id] = $class;
    }

    public static function getClassOf(string $id): ?string
    {
        return self::$registry[$id] ?? null;
    }

    public static function delete(string $id): bool
    {
        if (!array_key_exists($id, self::$registry)) {
            return false;
        }

        unset(self::$registry[$id]);

        return true;
    }

    public static function deleteClass(string $class): int
    {
        $toDelete = [];
        foreach (self::$registry as $id => $entry) {
            if ($entry === $class) {
                $toDelete[] = $id;
            }
        }
        foreach ($toDelete as $id) {
            unset(self::$registry[$id]);
        }

        return count($toDelete);
    }

    abstract protected static function validate(string $class): void;
}
