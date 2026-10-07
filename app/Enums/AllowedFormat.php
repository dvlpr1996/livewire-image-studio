<?php

declare(strict_types=1);

namespace App\Enums;

enum AllowedFormat: string
{
    case PNG = 'png';
    case  JPG = 'jpg';
    case JPEG = 'jpeg';
    case WEBP = 'webp';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
