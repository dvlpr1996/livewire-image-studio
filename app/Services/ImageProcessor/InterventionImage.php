<?php

declare(strict_types=1);

namespace App\Services\ImageProcessor;

use App\Enums\AllowedFormat;
use App\Services\ImageProcessor\contracts\ImageProcessorInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Alignment;
use Intervention\Image\Direction;
use Intervention\Image\Exceptions\DirectoryNotFoundException;
use Intervention\Image\Format;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ImageManagerInterface;
use RuntimeException;

final class InterventionImage implements ImageProcessorInterface
{
    public function __construct(
        private ImageManagerInterface $imageManager
    ) {}

    public function info(UploadedFile $photo): array
    {
        return $this->getImageInfo($this->imageManager->decode($photo), $photo->getRealPath());
    }

    public function process(UploadedFile $photo, string $batch, array $options): array
    {
        try {
            $image = $this->imageManager->decode($photo);

            if (($options['rotate'] ?? 0) !== 0) {
                $image->rotate(-$options['rotate']);
            }

            if (!empty($options['flipH'])) {
                $image->flip();
            }

            if (!empty($options['flipV'])) {
                $image->flip(Direction::VERTICAL);
            }

            if (($options['ratio'] ?? 'original') !== 'original') {
                [$this->cropToRatio($image, $options['ratio'])];
            }

            if (!empty($options['width'])) {
                $image->scaleDown(width: (int) $options['width']);
            }

            if (!empty($options['grayscale'])) {
                $image->grayscale();
            }

            if (!empty($options['brightness'])) {
                $image->brightness((int) $options['brightness']);
            }

            if (!empty($options['contrast'])) {
                $image->contrast((int) $options['contrast']);
            }

            if (!empty($options['sharpen'])) {
                $image->sharpen((int) $options['sharpen']);
            }

            if (!empty($options['blur'])) {
                $image->blur((int) $options['blur']);
            }

            if (!empty($options['watermark'])) {
                $this->applyWatermark($image, $options);
            }

            $quality = $options['quality'] ?? 80;

            $encoded = match ($options['format'] ?? AllowedFormat::WEBP->value) {
                AllowedFormat::JPEG->value,
                AllowedFormat::JPG->value => $image->encodeUsingFormat(Format::JPEG, quality: $quality),
                AllowedFormat::PNG->value => $image->encodeUsingFormat(Format::PNG),
                default => $image->encodeUsingFormat(Format::WEBP, quality: $quality),
            };

            if (!is_dir($batch)) {
                throw new DirectoryNotFoundException('internal server error, directory does not exist');
            }

            $encoded->save($batch . DIRECTORY_SEPARATOR . $photo->getClientOriginalName());

            return $this->getImageInfo($image, $photo->getRealPath());
        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?? 'internal server error');
        }
    }

    private function getImageInfo(ImageInterface $image, string $path): array
    {
        return $this->checkResult([
            'size' => filesize($path),
            'width' => $image->width(),
            'height' => $image->height(),
        ]);
    }

    private function checkResult(array $result): array
    {
        foreach ($result as $key => $value) {
            if ($value === null || $value === '' || empty($value)) {
                throw new RuntimeException("Image info is incomplete: '{$key}' could not be determined.");
            }
        }

        return $result;
    }

    private function cropToRatio(ImageInterface $image, string $ratio): void
    {
        [$rw, $rh] = array_map('intval', explode(':', $ratio));

        $width  = $image->width();
        $height = (int) round($width * $rh / $rw);

        if ($height > $image->height()) {
            $height = $image->height();
            $width  = (int) round($height * $rw / $rh);
        }

        $image->cover($width, $height);
    }

    private function applyWatermark(ImageInterface $image, array $options): void
    {
        $watermark = $this->imageManager
            ->decodePath(resource_path('images/watermarks/watermark.png'))
            ->scale(width: (int) max(120, $image->width() * 0.15));

        $margin = (int) round($image->width() * 0.02);

        $image->insert(
            $watermark,
            $margin,
            $margin,
            $options['position'] ?? Alignment::CENTER,
            $options['opacity'] ? 1 : 0
        );
    }
}
