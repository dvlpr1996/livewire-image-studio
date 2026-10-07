<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\HasEnumOptions;

enum AllowedAspectRatio: string
{
    use HasEnumOptions;

    case ORIGINAL = 'Original';
    case RATIO_1_1 = '1:1';
    case RATIO_16_9 = '16:9';
    case RATIO_4_3 = '4:3';
}
