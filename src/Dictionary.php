<?php

declare(strict_types=1);

/**
 * Contains the Dictionary class.
 *
 * @copyright   Copyright (c) 2025 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2025-01-11
 *
 */

namespace Konekt\Extend;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Dictionary implements ArrayAccess, Countable, IteratorAggregate
{
    protected array $data = [];

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function push(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->set((string) $key, $value);
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function doesntHave(string $key): bool
    {
        return !$this->has($key);
    }

    public function remove(string $key): void
    {
        unset($this->data[$key]);
    }

    public function all(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
