<p align="center">
  <img src="./screenshots/icon.png" alt="livewire image studio" width="96" height="96" />
</p>

<h1 align="center">Livewire Image Studio</h1>

A Livewire-powered image optimization studio for Laravel. Upload a batch of
images, resize, crop, rotate, filter and watermark them, then download
everything as a single ZIP — through a web UI or a REST API.

<p align="center">
  <img src="https://img.shields.io/badge/PHP-%5E8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version" />
  <img src="https://img.shields.io/badge/Laravel-%5E13.17-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Livewire-4-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 4" />
  <img src="https://img.shields.io/badge/Intervention_Image-%5E4.1-00A98F?style=for-the-badge" alt="Intervention Image" />
  <img src="https://img.shields.io/badge/License-Proprietary-EF4444?style=for-the-badge" alt="License" />
</p>

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Getting Started](#getting-started)
- [Environment Variables](#environment-variables)
- [Screenshots](#screenshots)
- [Road Map](#road-map)
- [Changelog](#changelog)
- [Credits](#credits)
- [License](#license)

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
- The `GD` and `intl` PHP extension

---

## Getting Started

```bash
git clone <repository-address>
cd livewire-image-studio

# First Enabled Gd And Intl Php Extensions

composer install
npm install

cp .env.example .env
php artisan key:generate

npm run dev
php artisan serve
```

---

## Environment variables

| Variable | Purpose | Default |
| --- | --- | --- |
| `APP_DEBUG` | Must be `false` in production | `true` |
| `LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK` | Disk used for Livewire's temporary uploads | `local` |

---

## Screenshots

## Road Map

- [ ] Add History Feature
- [ ] Add Api Feature

## Changelog

See [CHANGELOG.md](./CHANGELOG.md) for the full version history.

## Credits

- [Nima jahan bakhshian](https://github.com/dvlpr1996)

## License

This project is **`proprietary`**. All rights reserved. See [`LICENSE`](./LICENSE.md)
for full terms — the source is made available for **viewing** and **review only**;
no use, **modification**, or **redistribution** is permitted without written
permission from the copyright holder.
