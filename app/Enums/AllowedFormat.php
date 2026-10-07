<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\HasEnumOptions;

enum AllowedFormat: string
{
    use HasEnumOptions;

    case PNG = 'png';
    case  JPG = 'jpg';
    case JPEG = 'jpeg';
    case WEBP = 'webp';
}
