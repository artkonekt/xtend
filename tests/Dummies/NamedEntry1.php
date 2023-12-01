<?php

declare(strict_types=1);

/**
 * Contains the NamedEntry1 class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-12-01
 *
 */

namespace Konekt\Extend\Tests\Dummies;

class NamedEntry1 implements EntryWithNameButNotRegisterableInterface
{
    public static function getName(): string
    {
        return 'Named Entry 1';
    }
}
