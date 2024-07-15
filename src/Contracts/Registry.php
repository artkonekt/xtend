<?php

declare(strict_types=1);

/**
 * Contains the Registry interface.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend\Contracts;

interface Registry
{
    /**
     * Add an entry to the registry. If another entry with the same id already exists,
     * then the existing one will be kept and the method returns false. If no other
     * entry with the given id exists, then it gets added and *true* is returned
     */
    public static function add(string $id, string $class): bool;

    /**
     * Adds an entry to the registry regardless of whether it already exists or not.
     */
    public static function override(string $id, string $class): void;

    /** Deletes an entry from the registry by id and returns true.
     *  If there was no entry with the given ID, returns false.
     */
    public static function delete(string $id): bool;

    /**
     * Delete all occurrences of the given class.
     * It returns the number of entries deleted
     */
    public static function deleteClass(string $class): int;

    /** Returns the class of a registered entry or NULL if there's no such entry */
    public static function getClassOf(string $id): ?string;

    // @todo Add this to the contract in v2
    //public static function getIdOf(string $class): ?string;

    public static function reset(): void;

    public static function ids(): array;

    public static function choices(): array;

    /** Make an instance of the registered entry and return it */
    public static function make(string $id, array $parameters = []): object;
}
