<?php

declare(strict_types=1);

/**
 * Contains the TestResetableRegistry class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-12-01
 *
 */

namespace Konekt\Extend\Tests\Dummies;

use Konekt\Extend\Concerns\HasRegistry;
use Konekt\Extend\Concerns\RequiresClassOrInterface;
use Konekt\Extend\Contracts\Registry;

class TestResetableRegistry implements Registry
{
    use HasRegistry;
    use RequiresClassOrInterface;

    protected static string $requiredInterface = TestWidgetInterface::class;

    public static function make(string $id, array $parameters = []): TestWidgetInterface
    {
        return new self::$registry[$id]();
    }
}
