<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\HasEnumOptions;

enum AllowedRotateValue: int
{
    use HasEnumOptions;

    case ORIGINAL = 0;
    case DEGREE_90 = 90;
    case DEGREE_180 = 180;
    case DEGREE_270 = 270;
}
