# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- **History** — Persist files in the database instead of reading the `storage/app/tmp` directory directly, with per-user ownership, expiry, and re-download of past files.
- **API** — A documented, authenticated REST API (`/api/v1/images`) so images can be optimized from external apps and scripts, mirroring every option available in the image studio.

### Known Limitations

- History and API pages currently show a "Coming soon" placeholder.

## [0.1.0] - 2026-10-XX

### Added

- **Livewire image studio** — a Livewire-powered page to upload, preview and process a batch of images:
  - Optimize to WebP, JPG or PNG with an adjustable quality level
  - Resize with a maximum width (images only shrink, never enlarged)
  - Center crop to 1:1, 16:9 or 4:3
  - Rotate in 90° steps, with horizontal and vertical flip
  - Grayscale, brightness, contrast, sharpen and blur filters
  - Watermark placement in 9 positions with adjustable opacity
  - Live before/after image info (dimensions, file size, type)
  - Batch download as a single ZIP archive
- **Home** — a landing page introducing the product and its feature set
- Shared `ImageProcessor` service built on Intervention Image, used by the Studio UI
- UI built with Livewire, mary-ui, Tailwind CSS and daisyUI, with a custom light/dark theme
- Evaluation license restricting the project to local review and testing
