<?php

declare(strict_types=1);

namespace App\Services\StorageManagement;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class StorageManagement
{
    private readonly array $temporaryFileUpload;

    public function __construct()
    {
        $this->temporaryFileUpload = [
            'disk' => config('livewire.temporary_file_upload.disk', 'local'),
            'dir' => config('livewire.temporary_file_upload.directory', 'livewire-tmp')
        ];
    }

    public function disk(): Filesystem
    {
        return Storage::disk($this->temporaryFileUpload['disk']);
    }

    public function fileDirectory(string $fileName): string
    {
        return rtrim($this->temporaryFileUpload['dir'], '/') . '/' . $fileName;
    }

    public function fileNameGenerator(string $originalName, string $format): string
    {
        $name = trim(Str::slug(pathinfo($originalName, PATHINFO_FILENAME))
            . '-' . date('Y-m-d') . '.' . $format);
        return trim($name);
    }
}
