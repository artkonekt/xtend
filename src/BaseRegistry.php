<?php

declare(strict_types=1);

/**
 * Contains the BaseRegistry class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend;

use Konekt\Extend\Concerns\RequiresClassOrInterface;
use Konekt\Extend\Concerns\HasRegistry;
use Konekt\Extend\Contracts\Registry;

abstract class BaseRegistry implements Registry
{
    use HasRegistry;
    use RequiresClassOrInterface;
}
