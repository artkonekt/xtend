<?php

declare(strict_types=1);

/**
 * Contains the TestWidget class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend\Tests\Dummies;

class TestWidget implements TestWidgetInterface
{
    public static function getName(): string
    {
        return 'Test Widget';
    }
}
