<?php

declare(strict_types=1);

/**
 * Contains the TypedDictionary class.
 *
 * @copyright   Copyright (c) 2025 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2025-01-11
 *
 */

namespace Konekt\Extend;

class TypedDictionary extends Dictionary
{
    /** @var callable */
    protected $validator;

    public function __construct(callable $validator, array $data = [])
    {
        $this->validator = $validator;
        parent::__construct($data);
    }

    public static function ofClass(string $class): self
    {
        return new static(function ($instance) use ($class) {
            if ($instance instanceof $class) {
                return;
            }

            throw new \InvalidArgumentException(
                sprintf('The item you are trying to add is a(n) `%s` but it must be a(n) `%s`.', get_class($instance), $class)
            );
        });
    }

    public static function ofInterface(string $interface): self
    {
        return new static(function ($instance) use ($interface) {
            if ($instance instanceof $interface) {
                return;
            }

            throw new \InvalidArgumentException(
                sprintf('The object you are trying to add must implement the `%s` interface.', $interface)
            );
        });
    }

    public static function ofString(): self
    {
        return new static(fn ($item) => is_string($item) ?: throw new \InvalidArgumentException('The item must be a string.'));
    }

    public static function ofInteger(): self
    {
        return new static(fn ($item) => is_int($item) ?: throw new \InvalidArgumentException('The item must be an integer.'));
    }

    public static function ofFloat(): self
    {
        return new static(fn ($item) => is_float($item) ?: throw new \InvalidArgumentException('The item must be a float.'));
    }

    public static function ofBool(): self
    {
        return new static(fn ($item) => is_bool($item) ?: throw new \InvalidArgumentException('The item must be a boolean.'));
    }

    public function set(string $key, mixed $value): void
    {
        $this->validate($value);

        parent::set($key, $value);
    }

    /** Returns a COPY of the Dictionary filtered */
    public function filter(?callable $callback): static
    {
        return new static(
            $this->validator,
            array_filter($this->data, $callback, ARRAY_FILTER_USE_BOTH)
        );
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function validate(mixed $value): void
    {
        ($this->validator)($value);
    }
}
