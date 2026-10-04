# Livewire Image Studio

A Livewire-powered image optimization studio for Laravel. Upload a batch of
images, resize, crop, rotate, filter and watermark them, then download
everything as a single ZIP — through a web UI or a REST API.

---

## Features

- **Optimize** — convert to WebP, AVIF, JPG or PNG with a quality slider
- **Image info** — dimensions, file size and type, before and after
- **Resize** — cap the max width; images are only ever shrunk, never enlarged
- **Crop** — center crop to 1:1, 16:9 or 4:3
- **Rotate & flip** — 90°/180°/270° rotation, horizontal and vertical flip
- **Filters** — grayscale, brightness, contrast, sharpen, blur
- **Watermark** — logo placement in 9 positions with adjustable opacity
- **ZIP download** — every processed image delivered as one archive
- **Two interfaces** — a Livewire UI and a REST API, sharing the same
  processing service

---

## Tech stack

| Layer | Technology |
| --- | --- |
| Framework | Laravel |
| Interactivity | Livewire 4 |
| UI components | [mary-ui](https://mary-ui.com) |
| Styling | Tailwind CSS v4 + [daisyUI](https://daisyui.com/) |
| Client-side behavior | Alpine.js (bundled with Livewire) |
| Image processing | [Intervention Image](https://image.intervention.io) |

---

## Requirements

- PHP 8.3+
- Laravel 13.17
- Composer
- Node.js 18+ and npm
- The GD PHP extension

---

## Installation

```bash
git clone repository
cd livewire-image-studio

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate

npm run dev
php artisan serve
```

Place a transparent PNG watermark at `public/watermark.png` (used when the
watermark option is enabled).

---

## Environment variables

| Variable | Purpose | Default |
| --- | --- | --- |
| `APP_DEBUG` | Must be `false` in production | `true` |
| `LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK` | Disk used for Livewire's temporary uploads | `local` |

---

## Screenshots

## License

This project is **proprietary**. All rights reserved. See [`LICENSE`](./LICENSE.md)
for full terms — the source is made available for viewing and review only;
no use, modification, or redistribution is permitted without written
permission from the copyright holder.
