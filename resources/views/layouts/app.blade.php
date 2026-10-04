<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
		<meta charset="utf-8">
		<title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="robots" content="index, follow">
		<meta name="author" content="dvlpr1996 / Nima jahan bakhshian">
		<meta name="keywords" content="laravel, livewire, php, tailwind, image studio">
		<meta name="description" content="Optimize, resize, crop, rotate and watermark images in Laravel.">
		<meta name="theme-color" content="#e6ebf4" media="(prefers-color-scheme: light)">
		<meta name="theme-color" content="#0b1226" media="(prefers-color-scheme: dark)">
		<meta name="color-scheme" content="light dark">
		<link rel="icon" href="/favicon.ico" sizes="any">
		<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">

		@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

		<x-nav sticky full-width class="border-base-300 bg-base-200/85 sticky z-30 border-b py-1.5 backdrop-blur">
				<x-slot:brand>
						<label for="main-drawer" class="mr-3 lg:hidden">
								<x-icon name="o-bars-3" class="cursor-pointer" />
						</label>

						<a href="{{ route('home') }}" wire:navigate
								class="font-display flex items-center gap-2 text-xl font-extrabold tracking-tight">
								Image Studio
						</a>
				</x-slot:brand>

				<x-slot:actions style="gap:0.25rem">
						<x-ui.nav-link label="home" link="home" />
						<x-ui.nav-link label="history" link="history" />
						<x-ui.nav-link label="api" link="api.docs" />

						<x-theme-toggle class="btn-ghost btn-circle btn-sm" />
				</x-slot:actions>
		</x-nav>

		<x-main with-nav full-width>
				<x-slot:content>
						{{ $slot }}
				</x-slot:content>
		</x-main>

		<footer
				class="border-base-300 text-base-content/70 mt-10 flex flex-col items-center justify-center gap-2 border-t py-5 text-center text-sm">
				<span class="inline-block">Built with Laravel, Livewire, Tailwind and Alpine.</span>
				<span class="inline-block">© {{ date('Y') }} dvlpr1996. All rights reserved.</span>
		</footer>

		<x-toast />
</body>

</html>
