<?php

declare(strict_types=1);

/**
 * Contains the Registerable interface.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-12-01
 *
 */

namespace Konekt\Extend\Contracts;

interface Registerable
{
    public static function getName(): string;
}
