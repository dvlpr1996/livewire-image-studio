<?php

declare(strict_types=1);

use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

new #[Title('home')] class extends Component {
    use Toast;
}; ?>

<div>
		<section class="xs:py-5 grid gap-6 py-2.5 lg:grid-cols-2 lg:gap-12 lg:py-24">
				<div class="flex flex-col justify-center gap-3">
						<h1
								class="font-display xs:text-5xl text-4xl font-extrabold leading-[1.1] tracking-tight sm:leading-[1.01] lg:text-6xl">
								Smaller images.<br>Same picture.
						</h1>
						<p class="text-base-content/70 max-w-md text-lg">
								Drop in a batch, choose a format, then crop, rotate, tune and watermark. Download everything as one ZIP.
						</p>
						<div class="flex flex-row items-center justify-start gap-3">
								<x-button label="Open the studio" link="{{ route('studio') }}" class="btn-primary rounded-full" />
								<x-button label="Read the API docs" link="{{ route('api.docs') }}"
										class="btn-outline hidden rounded-full sm:flex" />
						</div>
				</div>

				<div class="border-base-300 bg-base-100 rounded-[36px] border p-5 md:mt-5 lg:p-10">
						<div class="flex items-center justify-between">
								<div>
										<p class="text-base-content/70 text-sm">Before</p>
										<p class="font-display text-xl font-extrabold tabular-nums">4.8 MB</p>
								</div>
								<x-icon name="o-arrow-right" class="text-base-content/40 size-5" />
								<div class="text-right">
										<p class="text-base-content/70 text-sm">After</p>
										<p class="font-display text-primary text-xl font-extrabold tabular-nums">312 KB</p>
								</div>
						</div>

						<div class="bg-base-300 mt-8 h-2 overflow-hidden rounded-full">
								<div class="bg-primary h-2 w-[7%] rounded-full"></div>
						</div>

						<p class="text-base-content/70 mt-4 text-center text-sm">
								<b class="text-base-content">93% smaller</b>, same picture.
						</p>
				</div>
		</section>

		<section class="lg:border-base-300 lg:border-t">
				<div class="grid gap-8 py-8 md:py-10 lg:grid-cols-[1fr_2fr] lg:py-16">
						<h2 class="font-display text-4xl font-extrabold tracking-tight">Everything a batch needs</h2>
						<dl class="divide-base-300 border-base-300 divide-y border-y">
								@foreach ([['Optimize', 'WebP, AVIF, JPG and PNG with a quality slider and a live size estimate.'], ['Image info', 'Dimensions, file size and type before you start, and before and after once you finish.'], ['Resize', 'Set a maximum width. Small images are left alone instead of blown up.'], ['Crop', 'Center crop to 1:1, 16:9 or 4:3.'], ['Rotate and flip', 'Quarter turns plus horizontal and vertical flips. Phone photos are auto-oriented.'], ['Filters', 'Grayscale, brightness, contrast, sharpen and blur.'], ['Watermark', 'Place your logo in any of nine positions at any opacity.'], ['ZIP download', 'Every processed image in one archive, ready to hand over.']] as [$title, $body])
										<div class="grid gap-1 py-4 sm:grid-cols-[190px_1fr]">
												<dt class="font-semibold">{{ $title }}</dt>
												<dd class="text-base-content/70">{{ $body }}</dd>
										</div>
								@endforeach
						</dl>
				</div>
		</section>
</div>
