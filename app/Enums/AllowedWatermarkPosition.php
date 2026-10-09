<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\HasEnumOptions;

enum AllowedWatermarkPosition: string
{
    use HasEnumOptions;

    case TOP_LEFT = 'top-left';
    case TOP = 'top';
    case TOP_RIGHT = 'top-right';
    case LEFT = 'left';
    case CENTER = 'center';
    case RIGHT = 'right';
    case BOTTOM_LEFT = 'bottom-left';
    case BOTTOM = 'bottom';
    case BOTTOM_RIGHT = 'bottom-right';
}
