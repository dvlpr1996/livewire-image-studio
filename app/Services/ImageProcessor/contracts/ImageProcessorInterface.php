<?php

declare(strict_types=1);

namespace App\Services\ImageProcessor\contracts;

use Illuminate\Http\UploadedFile;

interface ImageProcessorInterface
{
    public function info(UploadedFile $photo): array;

    public function process(UploadedFile $photo, string $batch, array $options): array;
}
