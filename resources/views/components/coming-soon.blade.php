@props(['title', 'description', 'icon' => 'o-clock'])

<div class="mx-auto flex max-w-xl flex-col items-center px-4 py-24 text-center">

		<div
				class="border-base-300 bg-base-100 text-base-content/70 my-2.5 space-x-1 rounded-full border px-8 py-2 text-sm font-semibold">
				<span class="bg-primary inline-block size-2 rounded-full"></span>
				<span class="inline-block">Coming soon</span>
		</div>

		<h1 class="font-display mt-6 text-4xl font-extrabold tracking-tight">{{ $title }}</h1>
		<p class="text-base-content/70 mt-3">{{ $description }}</p>

		<x-button label="Back to Studio" link="{{ route('home') }}" class="btn-primary mt-8 rounded-full px-6" />
</div>
