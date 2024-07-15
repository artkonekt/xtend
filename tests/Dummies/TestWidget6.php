<?php

declare(strict_types=1);

/**
 * Contains the TestWidget6 class.
 *
 * @copyright   Copyright (c) 2024 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-07-15
 *
 */

namespace Konekt\Extend\Tests\Dummies;

class TestWidget6 implements TestWidgetInterface
{
    public static function getName(): string
    {
        return 'Test Widget 6';
    }
}
