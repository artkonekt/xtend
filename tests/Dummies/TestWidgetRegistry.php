<?php

declare(strict_types=1);

/**
 * Contains the TestWidgetRegistry class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend\Tests\Dummies;

use Konekt\Extend\BaseRegistry;

class TestWidgetRegistry extends BaseRegistry
{
    protected static $requiredInterface = TestWidgetInterface::class;

    public static function make(string $id, array $parameters = []): TestWidgetInterface
    {
        return new self::$registry[$id]();
    }
}
