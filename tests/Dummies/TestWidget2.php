<?php

declare(strict_types=1);

/**
 * Contains the TestWidget2 class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend\Tests\Dummies;

class TestWidget2 implements TestWidgetInterface
{
    public static function getName(): string
    {
        return 'Test Widget 2';
    }
}
